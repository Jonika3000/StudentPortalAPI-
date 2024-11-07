<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    public const AVATAR_SIZES = [50, 150, 300, 600];

    public function __construct(private string $uploadDir)
    {
    }

    public function uploadImage(UploadedFile $uploadedFile, bool $resizeImages): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $uploadedFile->guessExtension();
        $systemDir = $this->uploadDir.'/avatars/';
        $newFilename = $originalFilename.'-'.uniqid().'.'.$extension;

        if ($resizeImages) {
            foreach (self::AVATAR_SIZES as $size) {
                $resizedFilename = $originalFilename.'-'.$size.'x'.$size.'.'.$extension;
                $resizedPath = $systemDir.$resizedFilename;

                ImageResize::image_resize($size, $size, $resizedPath, $uploadedFile);
            }
        }

        $fullPath = 'uploads/avatars/'.$newFilename;
        $uploadedFile->move($systemDir, $newFilename);

        return $fullPath;
    }
}
