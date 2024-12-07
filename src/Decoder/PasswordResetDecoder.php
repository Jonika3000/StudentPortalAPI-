<?php

namespace App\Decoder;

use App\Params\PasswordResetParams;
use App\Request\PasswordResetRequest;

class PasswordResetDecoder
{
    public function decode(PasswordResetRequest $request): PasswordResetParams
    {
        return new PasswordResetParams(
            $request->email
        );
    }
}
