<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 14:18
 */
namespace Notadd\Foundation\Flow;

use Illuminate\Container\Container;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;
use Symfony\Component\Workflow\MarkingStore\MultipleStateMarkingStore;
use Symfony\Component\Workflow\Workflow;

/**
 * Class Flow.
 */
class Flow extends Workflow
{
    /**
     * @var \Symfony\Component\Workflow\Definition
     */
    protected $definition;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * @var \Symfony\Component\Workflow\MarkingStore\MultipleStateMarkingStore
     */
    protected $markingStore;

    /**
     * @var string
     */
    protected $name;

    /**
     * Flow constructor.
     *
     * @param \Symfony\Component\Workflow\Definition                              $definition
     * @param \Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface|null $markingStore
     * @param string                                                              $name
     */
    public function __construct(Definition $definition, MarkingStoreInterface $markingStore = null, $name = 'unnamed')
    {
        $this->definition = $definition;
        $this->markingStore = $markingStore ?: new MultipleStateMarkingStore();
        $this->dispatcher = Container::getInstance()->make('events');
        $this->name = $name;
    }
}
