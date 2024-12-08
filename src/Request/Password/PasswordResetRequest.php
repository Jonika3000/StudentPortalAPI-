<?php

namespace App\Request\Password;

use App\Shared\BaseRequest;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordResetRequest extends BaseRequest
{
    #[NotBlank]
    public ?string $resetToken;

    #[NotBlank]
    public ?string $newPassword;
}
