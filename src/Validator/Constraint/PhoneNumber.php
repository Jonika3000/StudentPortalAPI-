<?php

namespace App\Validator\Constraint;

use App\Validator\PhoneNumberValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PhoneNumber extends Constraint
{
    public string $message = 'The phone number "{{ value }}" is not valid.';

    public function validatedBy(): string
    {
        return PhoneNumberValidator::class;
    }
}
