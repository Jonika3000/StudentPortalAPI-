<?php

namespace App\Params\FilesParams;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterFilesParams
{
    public function __construct(
        public UploadedFile $avatar,
    ) {
    }
}
