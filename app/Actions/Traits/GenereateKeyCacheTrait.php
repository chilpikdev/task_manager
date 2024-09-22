<?php

namespace App\Actions\Traits;

trait GenereateKeyCacheTrait
{
    public function generateKey(): string
    {
        $uri = request()->getUri();

        return  app()->getLocale() . ':' . sha1($uri);
    }
}
