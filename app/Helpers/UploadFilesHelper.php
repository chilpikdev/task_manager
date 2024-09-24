<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFilesHelper
{
    /**
     * Upload Multiple Files
     */
    public static function files(array $files, string $path, int $item_id): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            $uploadedFiles[] = self::file($file, $path, $item_id);
        }

        return $uploadedFiles;
    }

    /**
     * Upload One File
     */
    public static function file(object $file, string $path, int $item_id): string
    {
        $path = "{$path}/{$item_id}";

        $fileName = Str::random() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($path, $file, $fileName);

        $uploadedFile = $path . '/' . $fileName;

        return $uploadedFile;
    }
}
