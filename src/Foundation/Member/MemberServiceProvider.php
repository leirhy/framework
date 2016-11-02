<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 17:27
 */
namespace Notadd\Foundation\Member;
use Illuminate\Support\ServiceProvider;
/**
 * Class MemberServiceProvider
 * @package Notadd\Member
 */
class MemberServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('member', function($app) {
            $manager = new MemberManagement($app);
            $manager->setDefaultDriver('notadd');
            return $manager;
        });
        $this->app->singleton('member.driver', function() {
            $manager = $this->app->make('member');
            return $manager->driver();
        });
    }
}