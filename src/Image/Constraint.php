<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:15
 */
namespace Notadd\Foundation\Image;

/**
 * Class Constraint.
 */
class Constraint
{
    const ASPECTRATIO = 1;

    const UPSIZE = 2;

    /**
     * @var \Notadd\Foundation\Image\Size
     */
    private $size;

    /**
     * @var int
     */
    private $fixed = 0;

    /**
     * @param Size $size
     */
    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    /**
     * @return \Notadd\Foundation\Image\Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $type
     */
    public function fix($type)
    {
        $this->fixed = ($this->fixed & ~(1 << $type)) | (1 << $type);
    }

    /**
     * @param int $type
     *
     * @return bool
     */
    public function isFixed($type)
    {
        return (bool)($this->fixed & (1 << $type));
    }

    public function aspectRatio()
    {
        $this->fix(self::ASPECTRATIO);
    }

    public function upsize()
    {
        $this->fix(self::UPSIZE);
    }
}
