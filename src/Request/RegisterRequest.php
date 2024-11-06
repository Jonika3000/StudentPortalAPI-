<?php

namespace App\Request;

use App\Enums\Gender;
use App\Shared\BaseRequest;
use App\Validator\Constraint\OnlyLetters;
use App\Validator\Constraint\PhoneNumber;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterRequest extends BaseRequest
{
    #[NotBlank]
    public string $password;

    #[NotBlank]
    #[OnlyLetters]
    public string $firstName;

    #[NotBlank]
    #[OnlyLetters]
    public string $secondName;

    #[NotBlank]
    #[Type(\DateTimeInterface::class)]
    public ?\DateTimeInterface $birthday;

    #[NotBlank]
    #[Email]
    public ?string $email;

    #[NotBlank]
    public ?string $address;

    #[NotBlank]
    #[PhoneNumber]
    public ?string $phoneNumber = null;

    #[NotBlank]
    public ?Gender $gender = null;

    #[File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Please upload a valid JPEG or PNG image.'
    )]
    public ?UploadedFile $avatar = null;
}
