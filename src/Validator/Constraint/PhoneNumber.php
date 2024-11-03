<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PhoneNumber extends Constraint
{
    public string $message = 'The phone number "{{ value }}" is not valid.';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
