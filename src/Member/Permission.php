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
    protected $table = 'permissions';

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

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
}
