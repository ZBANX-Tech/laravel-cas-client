<?php


namespace Zbanx\CasClient\Traits;


use Illuminate\Support\Str;

trait CasUser
{
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        $keywords = [];
        foreach ($keywords as $keyword) {
            if (Str::is($keyword, $permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasAbility($key): bool
    {
        return true;
    }
}