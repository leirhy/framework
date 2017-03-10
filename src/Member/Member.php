<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 18:13
 */
namespace Notadd\Foundation\Member;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Notadd\Foundation\Auth\User as Authenticatable;

/**
 * Class Member.
 */
class Member extends Authenticatable
{
    use HasApiTokens;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 用户的权限
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'member_permission', 'member_id', 'permission_id');
    }

    /**
     * Get member instance for passport.
     *
     * @param $name
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Notadd\Foundation\Member\Member
     */
    public function findForPassport($name)
    {
        return $this->newQuery()->where('name', $name)->first();
    }

    /**
     * 获取缓存的用户的权限的动态键
     *
     * @return string
     */
    public function getCachePermissionKey()
    {
        $memberPrimaryKey = $this->primaryKey;

        return 'permissions_for_member_' . $this->$memberPrimaryKey;
    }

    public function cachedPermissions()
    {
        return Cache::remember($this->getCachePermissionKey(), 60, function () {
            return $this->permissions()->get();
        });
    }

    public function save(array $options = [])
    {
        //both inserts and updates
        $result = parent::save($options);

        Cache::forget($this->getCachePermissionKey());

        return $result;
    }

    public function delete()
    {
        // soft or hard
        $result = parent::delete();

        Cache::forget($this->getCachePermissionKey());

        return $result;
    }

    public function restore()
    {
        //soft delete undo's
        $result = parent::restore();

        Cache::forget($this->getCachePermissionKey());

        return $result;
    }

    /**
     * Boot the role model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the role model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($member) {

            if (! method_exists(static::class, 'bootSoftDeletes')) {
                $member->permissions()->sync([]);
            }

            return true;
        });
    }

    /**
     * Checks if the member has a permission by its name.
     *
     * @param string|array $name       Permission name or array of permission names.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasPermission($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);

                if ($hasPermission && ! $requireAll) {
                    return true;
                } elseif (! $hasPermission && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the permissions were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the permissions were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->cachedPermissions() as $permission) {
                if (str_is($name, $permission->name)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if the member has a admin permission by its name.
     *
     * @param string|array $name       Permission name or array of permission names.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasAdminPermission($name, $requireAll = false)
    {
        $adminName = $name;

        if (is_array($name)) {
            $adminName = array_map(function ($val) {
                if (ends_with($val, '*')) {
                    return $val;
                }

                return Permission::ADMIN_PREFIX . $val;
            }, $name);
        } else {

            if (! ends_with($name, '*')) {
                $adminName = Permission::ADMIN_PREFIX . $name;
            }
        }

        return $this->hasPermission($adminName, $requireAll);
    }

    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->attach($permission);
    }

    /**
     * Detach permission from current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function detachPermission($permission)
    {
        if (is_object($permission))
            $permission = $permission->getKey();

        if (is_array($permission))
            $permission = $permission['id'];

        $this->permissions()->detach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    /**
     * Detach multiple permissions from current role
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
}
