<?php

namespace App\Validator\Constraint;

use App\Validator\OnlyLettersValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class OnlyLetters extends Constraint
{
    public string $message = 'The value "{{ value }}" contains characters that are not allowed. Only letters are allowed.';

    public function validatedBy(): string
    {
        return OnlyLettersValidator::class;
    }
}
