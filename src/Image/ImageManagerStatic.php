<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 15:31
 */
namespace Notadd\Foundation\Image;

use Closure;

/**
 * Class ImageManagerStatic.
 */
class ImageManagerStatic
{
    /**
     * @var ImageManager
     */
    public static $manager;

    /**
     * ImageManagerStatic constructor.
     *
     * @param \Notadd\Foundation\Image\ImageManager|null $manager
     */
    public function __construct(ImageManager $manager = null)
    {
        self::$manager = $manager ? $manager : new ImageManager();
    }

    /**
     * @return ImageManager
     */
    public static function getManager()
    {
        return self::$manager ? self::$manager : new ImageManager();
    }

    /**
     * @param array $config
     *
     * @return ImageManager
     */
    public static function configure(array $config = [])
    {
        return self::$manager = self::getManager()->configure($config);
    }

    /**
     * @param mixed $data
     *
     * @return \Notadd\Foundation\Image\Image
     */
    public static function make($data)
    {
        return self::getManager()->make($data);
    }

    /**
     * @param int   $width
     * @param int   $height
     * @param mixed $background
     *
     * @return \Notadd\Foundation\Image\Image
     */
    public static function canvas($width, $height, $background = null)
    {
        return self::getManager()->canvas($width, $height, $background);
    }

    /**
     * @param Closure $callback
     * @param int     $lifetime
     * @param bool    $returnObj
     *
     * @return mixed
     */
    public static function cache(Closure $callback, $lifetime = null, $returnObj = false)
    {
        return self::getManager()->cache($callback, $lifetime, $returnObj);
    }
}
