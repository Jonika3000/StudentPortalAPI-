<?php

namespace App\Params\User;

class UserEditParams
{
    public function __construct(
        public string $address,
        public string $phoneNumber,
    ) {
    }
}
