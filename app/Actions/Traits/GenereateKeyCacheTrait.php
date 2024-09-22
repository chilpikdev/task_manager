<?php

namespace App\Actions\Traits;

trait GenereateKeyCacheTrait
{
    /**
     * Summary of generateKey
     * @return string
     */
    public function generateKey(): string
    {
        $uri = request()->getUri();

        return app()->getLocale() . ':' . sha1($uri);
    }
}
