<?php

namespace App\Decoder\Homework;

use App\Params\Homework\HomeworkPostParams;
use App\Request\Homework\HomeworkPostRequest;

class HomeworkPostDecoder
{
    public function decode(HomeworkPostRequest $request): HomeworkPostParams
    {
        return new HomeworkPostParams(
            $request->description,
            $request->lesson,
            $request->deadline
        );
    }
}
