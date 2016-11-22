<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 11:11
 */
namespace Notadd\Foundation\Member\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Member\Abstracts\Driver;
use Notadd\Foundation\Member\Member;

/**
 * Class MemberDeleted.
 */
class MemberDeleted
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Notadd\Foundation\Member\Member
     */
    protected $member;

    /**
     * MemberUpdated constructor.
     *
     * @param \Illuminate\Container\Container  $container
     * @param \Notadd\Foundation\Member\Member $member
     */
    public function __construct(Container $container, Member $member)
    {
        $this->container = $container;
        $this->member = $member;
    }
}
