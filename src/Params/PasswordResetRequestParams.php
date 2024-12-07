<?php

namespace App\Params;

class PasswordResetRequestParams
{
    public function __construct(
        public string $email,
    ) {
    }
}
