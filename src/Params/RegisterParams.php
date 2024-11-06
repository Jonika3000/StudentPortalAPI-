<?php

namespace App\Params;

use App\Enums\Gender;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterParams extends AbstractParams
{
    public function __construct(
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $password,
        public readonly string $secondName,
        public readonly string $address,
        public readonly string $phoneNumber,
        public readonly Gender $gender,
        public readonly \DateTimeInterface $birthday,
        public readonly ?UploadedFile $avatar = null,
    ) {
    }
}
