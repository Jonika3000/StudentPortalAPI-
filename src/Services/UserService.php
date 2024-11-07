<?php

namespace App\Services;

use App\Entity\User;
use App\Params\RegisterParams;
use App\Repository\UserRepository;
use App\Utils\FileHelper;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorService $validatorService,
        private UserRepository $userRepository,
        private FileHelper $fileHelper)
    {
    }

    public function postAction(
        RegisterParams $params, ?FileBag $files = null): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $params->password
        );
        $this->fileHelper->uploadAvatar($files->get('avatar'));
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
}