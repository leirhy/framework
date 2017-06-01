<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-29 16:18
 */
namespace Notadd\Foundation\Flow;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Notadd\Foundation\Flow\Contracts\SupportStrategy;

/**
 * Class FlowManager.
 */
class FlowManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * FlowManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->flows = new Collection();
    }

    /**
     * @param \Notadd\Foundation\Flow\Flow $flow
     * @param                              $supportStrategy
     *
     * @throws \Exception
     */
    public function add(Flow $flow, $supportStrategy)
    {
        if ($this->flows->has($flow->getName())) {
            throw new \Exception('The same named flow is added!');
        }
        if (!$supportStrategy instanceof SupportStrategy) {
            @trigger_error('Support of class name string was deprecated after version 3.2 and won\'t work anymore in 4.0.', E_USER_DEPRECATED);
            $supportStrategy = new ClassInstanceSupportStrategy($supportStrategy);
        }
        $this->flows->put($flow->getName(), [$flow, $supportStrategy]);
    }

    /**
     * @param $flow
     *
     * @return bool
     */
    public function exists($flow)
    {
        if (is_object($flow) && $flow instanceof Flow) {
            return $this->flows->has($flow->getName());
        }

        return $this->flows->has($flow);
    }

    /**
     * @param      $subject
     * @param null $name
     *
     * @return \Notadd\Foundation\Flow\Flow
     */
    public function get($subject, $name = null)
    {
        $matched = null;
        foreach ($this->flows as list($workflow, $supportStrategy)) {
            if ($this->supports($workflow, $supportStrategy, $subject, $name)) {
                if ($matched) {
                    throw new InvalidArgumentException('At least two workflows match this subject. Set a different name on each and use the second (name) argument of this method.');
                }
                $matched = $workflow;
            }
        }
        if (!$matched) {
            throw new InvalidArgumentException(sprintf('Unable to find a workflow for class "%s".', get_class($subject)));
        }

        return $matched;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->flows;
    }

    /**
     * @param \Notadd\Foundation\Flow\flow                      $workflow
     * @param \Notadd\Foundation\Flow\Contracts\SupportStrategy $supportStrategy
     * @param                                                   $subject
     * @param                                                   $workflowName
     *
     * @return bool
     */
    private function supports(flow $workflow, SupportStrategy $supportStrategy, $subject, $workflowName)
    {
        if (null !== $workflowName && $workflowName !== $workflow->getName()) {
            return false;
        }

        return $supportStrategy->supports($workflow, $subject);
    }
}
