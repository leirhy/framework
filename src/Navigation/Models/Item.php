<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-16 17:06
 */
namespace Notadd\Foundation\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item.
 */
class Item extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'color',
        'enabled',
        'group_id',
        'icon_image',
        'link',
        'order_id',
        'parent_id',
        'target',
        'title',
        'tooltip',
    ];

    /**
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * Return structured data.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function structure()
    {
        return $this->newQuery()->get();
    }
}
