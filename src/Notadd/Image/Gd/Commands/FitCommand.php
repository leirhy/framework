<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2015, iBenchu.org
 * @datetime 2016-05-19 18:04
 */
namespace Notadd\Image\Gd\Commands;
use Notadd\Image\Size;
/**
 * Class FitCommand
 * @package Notadd\Image\Gd\Commands
 */
class FitCommand extends ResizeCommand {
    /**
     * @param  \Notadd\Image\Image $image
     * @return boolean
     */
    public function execute($image) {
        $width = $this->argument(0)->type('digit')->required()->value();
        $height = $this->argument(1)->type('digit')->value($width);
        $constraints = $this->argument(2)->type('closure')->value();
        $position = $this->argument(3)->type('string')->value('center');
        $cropped = $image->getSize()->fit(new Size($width, $height), $position);
        $resized = clone $cropped;
        $resized = $resized->resize($width, $height, $constraints);
        $this->modify($image, 0, 0, $cropped->pivot->x, $cropped->pivot->y, $resized->getWidth(), $resized->getHeight(), $cropped->getWidth(), $cropped->getHeight());
        return true;
    }
}