<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-16 17:06
 */
namespace Notadd\Foundation\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group.
 */
class Group extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'alias',
        'title',
    ];

    /**
     * @var string
     */
    protected $table = 'menu_groups';
}
