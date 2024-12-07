<?php

namespace App\Services;

use App\Entity\User;
use App\Params\FilesParams\RegisterFilesParams;
use App\Params\RegisterParams;
use App\Repository\UserRepository;
use App\Utils\FileHelper;
use Random\RandomException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

readonly class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorService $validatorService,
        private UserRepository $userRepository,
        private FileHelper $fileHelper,
        private MailerService $mailerService,
        private ParameterBagInterface $params,
    ) {
    }

    public function postAction(
        RegisterParams $params, ?RegisterFilesParams $files = null): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $params->password
        );
        $avatarPath = $this->fileHelper->uploadImage($files->avatar, '/avatars/', true);
        $user->setAvatarPath($avatarPath);
        $user->setPassword($hashedPassword);
        $user->setBirthday($params->birthday);
        $user->setEmail($params->email);
        $user->setFirstName($params->firstName);
        $user->setGender($params->gender);
        $user->setPhoneNumber($params->phoneNumber);
        $user->setAddress($params->address);
        $user->setSecondName($params->secondName);

        $this->validatorService->validateObject($user);

        $this->userRepository->saveUser($user);

        return $user;
    }

    public function getUserByToken(TokenInterface $token): \Symfony\Component\Security\Core\User\UserInterface
    {
        return $token->getUser();
    }

    /**
     * @throws RandomException
     * @throws TransportExceptionInterface
     */
    public function resetPasswordRequest(string $email): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return new JsonResponse(['message' => 'If the email exists, a reset link will be sent.'], 200);
        }

        $resetToken = bin2hex(random_bytes(32));
        $user->setResetToken($resetToken);
        $user->setResetTokenExpiry(new \DateTime('+1 hour'));
        $this->userRepository->saveUser($user);

        $resetLink = sprintf($this->params->get('frontend')
            .'/reset-password/%s', $resetToken);

        $this->mailerService->sendMail(
            $user->getEmail(),
            'Password Reset Request',
            'email/password/password_reset_request_email.html.twig',
            ['resetLink' => $resetLink]
        );

        return new JsonResponse(['message' => 'If the email exists, a reset link will be sent.'], 200);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function passwordReset(
        $resetToken,
        $newPassword,
    ): JsonResponse {
        $user = $this->userRepository->findOneBy(['resetToken' => $resetToken]);
        if (!$user || $user->getResetTokenExpiry() < new \DateTime()) {
            return new JsonResponse(['message' => 'Invalid or expired reset token.'], 400);
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));
        $user->setResetToken(null);
        $user->setResetTokenExpiry(null);
        $this->userRepository->saveUser($user);

        $this->mailerService->sendMail(
            $user->getEmail(),
            'Password Successfully Changed',
            'email/password/password_reset_success_email.html.twig'
        );

        return new JsonResponse(['message' => 'Password successfully reset.'], 200);
    }
}
