<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:43
 */
namespace Notadd\Foundation\Auth;
/**
 * Class RedirectsUsers
 * @package Notadd\Foundation\Auth
 */
trait RedirectsUsers {
    /**
     * @return string
     */
    public function redirectPath() {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}