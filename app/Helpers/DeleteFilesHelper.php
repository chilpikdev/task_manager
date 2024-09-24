<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class DeleteFilesHelper
{
    public static function file(string $path): void
    {
        if (Storage::disk('public')->exists($path))
            Storage::disk('public')->delete($path);
    }

    public static function files(array $files): void
    {
        foreach ($files as $file) {
            self::file($file);
        }
    }
}
