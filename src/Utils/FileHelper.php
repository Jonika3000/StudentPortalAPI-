<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    public const AVATAR_SIZES = [50, 150, 300, 600];

    public function __construct(private string $uploadDir)
    {
    }

    public function uploadAvatar(UploadedFile $uploadedFile): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $uploadedFile->guessExtension();

        $newFilename = $originalFilename.'-'.uniqid().'.'.$extension;

        foreach (self::AVATAR_SIZES as $size) {
            $resizedFilename = $originalFilename.'-'.$size.'x'.$size.'.'.$extension;
            $resizedPath = $this->uploadDir.'/avatars/'.$resizedFilename;

            ImageResize::image_resize($size, $size, $resizedPath, $uploadedFile);
        }
        $uploadedFile->move($this->uploadDir.'/avatars/', $newFilename);

        return $newFilename;
    }
}
