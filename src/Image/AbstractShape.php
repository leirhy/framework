<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:14
 */
namespace Notadd\Foundation\Image;

/**
 * Class AbstractShape.
 */
abstract class AbstractShape
{
    /**
     * @var string
     */
    public $background;

    /**
     * @var string
     */
    public $border_color;

    /**
     * @var int
     */
    public $border_width = 0;

    /**
     * @param Image $image
     * @param int   $posx
     * @param int   $posy
     *
     * @return bool
     */
    abstract public function applyToImage(Image $image, $posx = 0, $posy = 0);

    /**
     * @param $color
     */
    public function background($color)
    {
        $this->background = $color;
    }

    /**
     * @param int    $width
     * @param string $color
     */
    public function border($width, $color = null)
    {
        $this->border_width = is_numeric($width) ? intval($width) : 0;
        $this->border_color = is_null($color) ? '#000000' : $color;
    }

    /**
     * @return bool
     */
    public function hasBorder()
    {
        return $this->border_width >= 1;
    }
}
