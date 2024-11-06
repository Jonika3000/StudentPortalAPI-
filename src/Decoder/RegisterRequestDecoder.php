<?php

namespace App\Decoder;

use App\Params\RegisterParams;
use App\Request\RegisterRequest;

class RegisterRequestDecoder
// implements RequestDecoderInterface
{
    public function decode(RegisterRequest $request): RegisterParams
    {
        return new RegisterParams(
            $request->email,
            $request->firstName,
            $request->password,
            $request->secondName,
            $request->address,
            $request->phoneNumber,
            $request->gender,
            $request->birthday,
            $request->avatar
        );
    }
}
