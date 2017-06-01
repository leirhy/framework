<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 15:55
 */
namespace Notadd\Foundation\Flow\Abstracts;

use Illuminate\Container\Container;
use Notadd\Foundation\Member\Member;

/**
 * Class Entity.
 */
abstract class Entity
{
    /**
     * @var mixed
     */
    protected $currentState;

    /**
     * @var \Notadd\Foundation\Member\Member
     */
    protected $user;

    /**
     * Entity constructor.
     *
     * @param \Notadd\Foundation\Member\Member|null $user
     */
    public function __construct(Member $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @return \Notadd\Foundation\Member\Member
     */
    public function getUser(): \Notadd\Foundation\Member\Member
    {
        if (is_null($this->user)) {
            $auth = Container::getInstance()->make('auth');
            return $auth->guard()->user();
        }

        return $this->user;
    }

    /**
     * @param mixed $currentState
     */
    public function setCurrentState($currentState)
    {
        $this->currentState = $currentState;
    }
}
