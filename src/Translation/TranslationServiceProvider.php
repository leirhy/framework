<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-01 15:27
 */
namespace Notadd\Foundation\Translation;

use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;

/**
 * Class TranslationServiceProvider.
 */
class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
