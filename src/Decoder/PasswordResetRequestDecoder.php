<?php

namespace App\Decoder;

use App\Params\PasswordResetRequestParams;
use App\Request\PasswordResetRequestRequest;

class PasswordResetRequestDecoder
{
    public function decode(PasswordResetRequestRequest $request): PasswordResetRequestParams
    {
        return new PasswordResetRequestParams(
            $request->email
        );
    }
}
