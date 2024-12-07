<?php

namespace App\Params;

class UserEditParams
{
    public function __construct(
        public string $address,
        public string $phoneNumber,
    ) {
    }
}
