<?php

namespace App\Request;

use App\Enums\Gender;
use App\Shared\BaseRequest;
use App\Validator\Constraint\OnlyLetters;
use App\Validator\Constraint\PhoneNumber;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterRequest extends BaseRequest
{
    #[NotBlank]
    #[Groups('input')]
    public string $password;

    #[NotBlank]
    #[OnlyLetters]
    #[Groups('input')]
    public string $firstName;

    #[NotBlank]
    #[OnlyLetters]
    #[Groups('input')]
    public string $secondName;

    #[NotBlank]
    #[Groups('input')]
    #[Type(\DateTimeInterface::class)]
    public ?\DateTimeInterface $birthday;

    #[NotBlank]
    #[Email]
    #[Groups('input')]
    public ?string $email;

    #[NotBlank]
    #[Groups('input')]
    public ?string $address;

    #[NotBlank]
    #[PhoneNumber]
    #[Groups('input')]
    public ?string $phoneNumber = null;

    #[NotBlank]
    #[Groups('input')]
    public ?Gender $gender = null;
}
