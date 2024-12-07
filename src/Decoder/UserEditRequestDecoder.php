<?php

namespace App\Decoder;

use App\Params\RegisterParams;
use App\Params\UserEditParams;
use App\Request\RegisterRequest;
use App\Request\UserEditRequest;

class UserEditRequestDecoder
// implements RequestDecoderInterface
{
    public function decode(UserEditRequest $request): UserEditParams
    {
        return new UserEditParams(
            $request->address,
            $request->phoneNumber,
        );
    }
}
