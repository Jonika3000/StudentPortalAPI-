<?php

namespace App\Params\Password;

class PasswordResetParams
{
    public function __construct(
        public string $resetToken,
        public string $newPassword,
    ) {
    }
}