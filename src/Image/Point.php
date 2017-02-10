<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:32
 */
namespace Notadd\Foundation\Image;

/**
 * Class Point.
 */
class Point
{
    /**
     * @var int
     */
    public $x;

    /**
     * @var int
     */
    public $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct($x = null, $y = null)
    {
        $this->x = is_numeric($x) ? intval($x) : 0;
        $this->y = is_numeric($y) ? intval($y) : 0;
    }

    /**
     * @param int $x
     */
    public function setX($x)
    {
        $this->x = intval($x);
    }

    /**
     * @param int $y
     */
    public function setY($y)
    {
        $this->y = intval($y);
    }

    /**
     * @param int $x
     * @param int $y
     */
    public function setPosition($x, $y)
    {
        $this->setX($x);
        $this->setY($y);
    }
}
