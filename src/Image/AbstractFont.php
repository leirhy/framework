<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:13
 */
namespace Notadd\Foundation\Image;

/**
 * Class AbstractFont.
 */
abstract class AbstractFont
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var int
     */
    public $size = 12;

    /**
     * @var mixed
     */
    public $color = '000000';

    /**
     * @var int
     */
    public $angle = 0;

    /**
     * @var string
     */
    public $align;

    /**
     * @var string
     */
    public $valign;

    /**
     * @var mixed
     */
    public $file;

    /**
     * @param Image $image
     * @param int   $posx
     * @param int   $posy
     *
     * @return bool
     */
    abstract public function applyToImage(Image $image, $posx = 0, $posy = 0);

    /**
     * AbstractFont constructor.
     *
     * @param null $text
     */
    public function __construct($text = null)
    {
        $this->text = $text;
    }

    /**
     * @param string $text
     */
    public function text($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param int $size
     */
    public function size($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $color
     */
    public function color($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param int $angle
     */
    public function angle($angle)
    {
        $this->angle = $angle;
    }

    /**
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param string $align
     */
    public function align($align)
    {
        $this->align = $align;
    }

    /**
     * @return string
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @param string $valign
     */
    public function valign($valign)
    {
        $this->valign = $valign;
    }

    /**
     * @return string
     */
    public function getValign()
    {
        return $this->valign;
    }

    /**
     * @param string $file
     */
    public function file($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return bool
     */
    protected function hasApplicableFontFile()
    {
        if (is_string($this->file)) {
            return file_exists($this->file);
        }

        return false;
    }

    /**
     * @return int
     */
    public function countLines()
    {
        return count(explode(PHP_EOL, $this->text));
    }
}
