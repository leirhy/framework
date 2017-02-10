<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 18:16
 */
namespace Notadd\Foundation\Image\Gd\Commands;

use Notadd\Foundation\Image\Commands\AbstractCommand;

/**
 * Class GreyscaleCommand.
 */
class GreyscaleCommand extends AbstractCommand
{
    /**
     * @param \Notadd\Foundation\Image\Image $image
     *
     * @return bool
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_GRAYSCALE);
    }
}
