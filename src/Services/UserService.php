<?php

namespace App\Services;

use App\Constants\UserRoles;
use App\Entity\User;
use App\Enums\Gender;
use App\Utils\Converter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

readonly class UserService
{
    public function __construct(private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorService $validatorService)
    {
    }

    public function createNewUser(
        array $data): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setUuid(Uuid::v4());
        $user->setPassword($hashedPassword);
        $user->setRoles([UserRoles::USER]);
        $user->setGender(Gender::tryFrom($data['gender']));
        $user->setBirthday(Converter::convertToDateTime($data['birthday']));
        $user->hydrate($data);
        $this->validatorService->validateObject($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
