<?php

namespace App\Services;

use App\Constants\UserRoles;
use App\Entity\User;
use App\Enums\Gender;
use App\Repository\UserRepository;
use App\Utils\Converter;
use App\Utils\FileHelper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

readonly class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorService $validatorService,
        private UserRepository $userRepository,
        private FileHelper $fileHelper)
    {
    }

    public function createNewUser(
        array $data, ?array $files = null): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $this->fileHelper->uploadAvatar();
        $user->setUuid(Uuid::v4());
        $user->setPassword($hashedPassword);
        $user->setRoles([UserRoles::USER]);
        $user->setGender(Gender::tryFrom($data['gender']));
        $user->setBirthday(Converter::convertToDateTime($data['birthday']));
        $user->hydrate($data);
        $this->validatorService->validateObject($user);

        $this->userRepository->saveUser($user);

        return $user;
    }
}
