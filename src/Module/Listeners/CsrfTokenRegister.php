<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-18 19:02
 */
namespace Notadd\Foundation\Module\Listeners;

use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Http\Events\CsrfTokenRegister as CsrfTokenRegisterEvent;

/**
 * Class CsrfTokenRegister.
 */
class CsrfTokenRegister extends EventSubscriber
{
    /**
     * Name of event.
     *
     * @throws \Exception
     * @return string|object
     */
    protected function getEvent()
    {
        return CsrfTokenRegisterEvent::class;
    }

    /**
     * Register excepts.
     *
     * @param $event
     */
    public function handle(CsrfTokenRegisterEvent $event)
    {
        $event->registerExcept('api/module*');
    }
}
