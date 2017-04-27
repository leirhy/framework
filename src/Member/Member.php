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
use Notadd\Foundation\Auth\User as Authenticatable;

/**
 * Class Member.
 */
class Member extends Authenticatable
{
    use HasApiTokens;

    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

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
     * Member constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->cache = $this->container->make('cache');
    }

    /**
     * Permissions for member.
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
     * Get cache key for user permission.
     *
     * @return string
     */
    public function getCachePermissionKey()
    {
        $memberPrimaryKey = $this->primaryKey;

        return 'permissions_for_member_' . $this->$memberPrimaryKey;
    }

    /**
     * Get cached permissions data.
     *
     * @return mixed
     */
    public function cachedPermissions()
    {
        return $this->cache->remember($this->getCachePermissionKey(), 60, function () {
            return $this->permissions()->get();
        });
    }

    /**
     * Save the model to the database.
     *
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        //both inserts and updates
        $result = parent::save($options);
        $this->cache->forget($this->getCachePermissionKey());

        return $result;
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete()
    {
        // soft or hard
        $result = parent::delete();
        $this->cache->forget($this->getCachePermissionKey());

        return $result;
    }

    public function restore()
    {
        //soft delete undo's
        $result = parent::restore();
        $this->cache->forget($this->getCachePermissionKey());

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
        static::deleting(function ($member) {
            if (!method_exists(static::class, 'bootSoftDeletes')) {
                $member->permissions()->sync([]);
            }

            return true;
        });
    }

    /**
     * Checks if the member has a permission by its name.
     *
     * @param string|array $name Permission name or array of permission names.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasPermission($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);
                if ($hasPermission && !$requireAll) {
                    return true;
                } elseif (!$hasPermission && $requireAll) {
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
     * 判断是否有前台的权限, 支持 * 通赔符
     *
     * @param      $name
     * @param bool $requireAll
     *
     * @return bool
     */
    public function hasFrontPermission($name, $requireAll = false)
    {
        if (is_array($name)) {
            $name = array_map(function ($val) {
                if (ends_with($val, '*')) {
                    return $val;
                }

                return Permission::FRONT_PREFIX . $val;
            }, $name);
        } else {
            if (!ends_with($name, '*')) {
                $name = Permission::FRONT_PREFIX . $name;
            }
        }

        return $this->hasPermission($name, $requireAll);
    }

    /**
     * Checks if the member has a admin permission by its name.
     *
     * @param string|array $name Permission name or array of permission names.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasAdminPermission($name, $requireAll = false)
    {
        if (is_array($name)) {
            $name = array_map(function ($val) {
                if (ends_with($val, '*')) {
                    return $val;
                }

                return Permission::ADMIN_PREFIX . $val;
            }, $name);
        } else {
            if (!ends_with($name, '*')) {
                $name = Permission::ADMIN_PREFIX . $name;
            }
        }

        return $this->hasPermission($name, $requireAll);
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
