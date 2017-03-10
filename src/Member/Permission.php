<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-14 16:04
 */

namespace Notadd\Foundation\Member;

use Notadd\Foundation\Database\Model;

/**
 * Class Permission
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $display_name
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @package Notadd\Foundation\Member
 */
class Permission extends Model
{
    const ADMIN_PREFIX = 'admin.';

    protected $table = 'permissions';

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_permission', 'permission_id', 'member_id');
    }

    public static function addPermission($name, $display_name = null, $description = null)
    {
        $permission = static::where('name', $name)->first();

        if (! $permission || ! $permission->exists) {
            $permission = new static(['name' => $name]);
        }

        $permission->display_name = $display_name;
        $permission->description  = $description;
        $permission->save();

        return $permission;
    }

    /**
     * 添加后台权限
     *
     * @param      $name
     * @param null $display_name
     * @param null $description
     *
     * @return \Notadd\Foundation\Member\Permission
     */
    public static function addAdminPermission($name, $display_name = null, $description = null)
    {
        return static::addPermission(static::ADMIN_PREFIX . $name, $display_name, $description);
    }

    /**
     * 查询后台权限
     *
     * @param $query
     * @param $name
     *
     * @return mixed
     */
    public function scopeWhereAdmin($query, $name)
    {
        return $query->where('name', static::ADMIN_PREFIX . $name);
    }
}
