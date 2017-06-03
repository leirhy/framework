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
use Illuminate\Support\Collection;
use Notadd\Foundation\Flow\FlowBuilder;
use Notadd\Foundation\Member\Member;
use Symfony\Component\Workflow\Transition;

/**
 * Class Entity.
 */
abstract class Entity extends FlowBuilder
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
     * Announce a transition.
     */
    abstract public function announce();

    /**
     * Enter a place.
     */
    abstract public function enter();

    /**
     * Entered a place.
     */
    abstract public function entered();

    /**
     * Guard a transition.
     */
    abstract public function guard();

    /**
     * Leave a place.
     */
    abstract public function leave();

    /**
     * Into a transition.
     */
    abstract public function transition();

    /**
     * @return array
     */
    public function events()
    {
        $collection = new Collection();
        $name = method_exists($this, 'name') ? $this->{'name'}() : 'unnamed';
        $places = method_exists($this, 'places') ? $this->{'places'}() : [];
        if (method_exists($this, 'transitions')) {
            $transitions = $this->{'transitions'}();
            $transitions = collect($transitions)->transform(function (Transition $transition) {
                return $transition->getName();
            })->toArray();
        } else {
            $transitions = [];
        }
        foreach ($places as $place) {
            $collection->put('flow.' . $name . '.enter', 'enter');
            $collection->put('flow.' . $name . '.enter.' . $place, 'enter' . ucfirst($place));
            $collection->put('flow.' . $name . '.entered', 'entered');
            $collection->put('flow.' . $name . '.entered.' . $place, 'entered' . ucfirst($place));
            $collection->put('flow.' . $name . '.leave', 'leave');
            $collection->put('flow.' . $name . '.leave.' . $place, 'leave' . ucfirst($place));
        }
        foreach ($transitions as $transition) {
            $collection->put('flow.' . $name . '.announce', 'announce');
            $collection->put('flow.' . $name . '.announce.' . $transition, 'announce' . ucfirst($transition));
            $collection->put('flow.' . $name . '.guard', 'guard');
            $collection->put('flow.' . $name . '.guard.' . $transition, 'guard' . ucfirst($transition));
            $collection->put('flow.' . $name . '.transition', 'transition');
            $collection->put('flow.' . $name . '.transition.' . $transition, 'transition' . ucfirst($transition));
        }

        return $collection->toArray();
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
