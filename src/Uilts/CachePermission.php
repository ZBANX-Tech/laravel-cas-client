<?php


namespace Zbanx\CasClient\Uilts;


use Illuminate\Support\Facades\Cache;

class CachePermission
{
    public static function setPermissions($user_id, $data): bool
    {
        $ttl = config('cas.ttl', 7200);
        return Cache::put(self::getKey($user_id), $data, $ttl);
    }

    public static function getPermissions($user_id)
    {
        return Cache::get(self::getKey($user_id), [
            'menus' => [],
            'keywords' => [],
            'abilities' => [],
        ]);
    }

    private static function getKey($user_id): string
    {
        return config('cas.cache.prefix') . ':' . $user_id;
    }
}