<?php

namespace App\Decoder\FileBagDecoder;

use App\Params\FilesParams\RegisterFilesParams;
use Symfony\Component\HttpFoundation\FileBag;

class RegisterFileBagDecoder
{
    public function decode(FileBag $fileBag): RegisterFilesParams
    {
        return new RegisterFilesParams(
            $fileBag->get('avatar')
        );
    }
}
