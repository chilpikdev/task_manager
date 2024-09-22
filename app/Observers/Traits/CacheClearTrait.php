<?php

namespace App\Observers\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

trait CacheClearTrait
{
    /**
     * Summary of clear
     * @param string $key
     * @return void
     */
    public function clear(string $key): void
    {
        foreach (Redis::keys("*{$key}*") as $cacheValue)
        {
            Cache::forget(substr($cacheValue, strripos($cacheValue, $key)));
        }
    }
}
