<?php

namespace App\Request;

use App\Shared\BaseRequest;
use App\Validator\Constraint\PhoneNumber;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditRequest extends BaseRequest
{
    #[NotBlank]
    public ?string $address;

    #[NotBlank]
    #[PhoneNumber]
    public ?string $phoneNumber = null;
}