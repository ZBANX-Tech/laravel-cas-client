<?php


namespace Zbanx\CasClient\Uilts;


use Illuminate\Support\Facades\Cache;

class CachePermission
{
    public static function setPermissions($user_id, $data): bool
    {
        $ttl = config('cas.ttl', 7200);
        Cache::put(self::getPermissionKey($user_id), $data, $ttl);
    }

    public static function getPermissions($user_id)
    {
        return Cache::get(self::getPermissionKey($user_id), [
            'menus' => [],
            'keywords' => [],
            'abilities' => [],
        ]);
    }

    public static function setUserTicket($user_id, $ticket)
    {
        $ttl = config('cas.ttl', 7200);
        Cache::put(self::getTicketKey($user_id), $ticket, $ttl);
    }

    public static function getUserTicket($user_id, $ticket)
    {
        return Cache::get(self::getPermissionKey($user_id));
    }

    private static function getPermissionKey($user_id): string
    {
        return config('cas.cache.prefix') . '_permissions:' . $user_id;
    }

    private static function getTicketKey($user_id): string
    {
        return config('cas.cache.prefix') . '_tickets:' . $user_id;
    }
}