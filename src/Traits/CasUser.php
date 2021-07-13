<?php


namespace Zbanx\CasClient\Traits;


use Illuminate\Support\Str;
use Zbanx\CasClient\Uilts\CasCache;

trait CasUser
{
    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        $permissions = CasCache::getPermissions($this->id);
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

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return CasCache::getPermissions($this->id);
    }
}