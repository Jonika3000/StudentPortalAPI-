<?php

namespace App\Params\Password;

class PasswordResetRequestParams
{
    public function __construct(
        public string $email,
    ) {
    }
}
