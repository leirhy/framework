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

class Permission extends Model
{
    protected $table = 'permission';

    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
