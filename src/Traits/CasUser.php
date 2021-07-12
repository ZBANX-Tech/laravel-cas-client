<?php


namespace Zbanx\CasClient\Traits;


use Illuminate\Support\Str;
use Zbanx\CasClient\Uilts\CachePermission;

trait CasUser
{
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        $permissions = CachePermission::getPermissions($this->id);
        foreach ($permissions['keywords'] as $keyword) {
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