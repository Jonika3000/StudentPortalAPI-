<?php

namespace App\Decoder;

use App\Params\AbstractParams;
use App\Shared\BaseRequest;

interface RequestDecoderInterface
{
    public function decode(BaseRequest $request): AbstractParams;
}
