<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 15:23
 */
namespace Notadd\Foundation\Mail;
use Illuminate\Mail\MailServiceProvider as IlluminateMailServiceProvider;
/**
 * Class MailServiceProvider
 * @package Notadd\Foundation\Mail
 */
class MailServiceProvider extends IlluminateMailServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
}