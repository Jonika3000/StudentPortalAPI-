<?php

namespace App\Params;

class PasswordResetParams
{
    public function __construct(
        public string $resetToken,
        public string $newPassword,
    ) {
    }
}
