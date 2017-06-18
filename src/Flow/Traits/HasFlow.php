<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-18 15:53
 */
namespace Notadd\Foundation\Flow\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Permission\PermissionManager;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;

/**
 * Trait HasFlow.
 */
trait HasFlow
{
    /**
     * Definition of name for flow.
     *
     * @return string
     */
    abstract public function name();

    /**
     * Definition of places for flow.
     *
     * @return array
     */
    abstract public function places();

    /**
     * Definition of transitions for flow.
     *
     * @return array
     */
    abstract public function transitions();


    /**
     * Announce a transition.
     */
    public function announceTransition()
    {
    }

    /**
     * Enter a place.
     *
     * @param \Symfony\Component\Workflow\Event\Event $event
     */
    public function enterPlace(Event $event)
    {
    }

    /**
     * Entered a place.
     */
    public function enteredPlace()
    {
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    abstract public function guardTransition(GuardEvent $event);

    /**
     * Leave a place.
     */
    public function leavePlace()
    {
    }

    /**
     * Into a transition.
     */
    public function intoTransition()
    {
    }

    /**
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     * @param bool                                         $permission
     */
    protected function blockTransition(GuardEvent $event, bool $permission)
    {
        if ($permission) {
            $event->setBlocked(false);
        } else {
            $event->setBlocked(true);
        }
    }

    /**
     * @return array
     */
    public function registerFlowEvents()
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
            $collection->put('flow.' . $name . '.enter', 'enterPlace');
            $collection->put('flow.' . $name . '.entered', 'enteredPlace');
            $collection->put('flow.' . $name . '.leave', 'leavePlace');
        }
        foreach ($transitions as $transition) {
            $collection->put('flow.' . $name . '.announce', 'announceTransition');
            $collection->put('flow.' . $name . '.guard', 'guardTransition');
            $collection->put('flow.' . $name . '.transition', 'intoTransition');
        }

        return $collection->toArray();
    }

    /**
     * @param $identification
     *
     * @param $group
     *
     * @return bool
     */
    protected function permission($identification, $group)
    {
        if ($group instanceof Model) {
            $group = $group->getAttribute('identification');
        } else if ($group instanceof Collection) {
            $group = $group->transform(function (Model $group) {
                return $group->getAttribute('identification');
            })->toArray();
        }
        foreach ((array)$group as $item) {
            if (Container::getInstance()->make(PermissionManager::class)->check($identification, $item)) {
                return true;
            }
        }

        return false;
    }
}
