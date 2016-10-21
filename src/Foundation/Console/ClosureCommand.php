<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:00
 */
namespace Notadd\Foundation\Console;
use Closure;
use ReflectionFunction;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Class ClosureCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class ClosureCommand extends Command {
    /**
     * @var \Closure
     */
    protected $callback;
    /**
     * ClosureCommand constructor.
     * @param string $signature
     * @param \Closure $callback
     */
    public function __construct($signature, Closure $callback) {
        $this->callback = $callback;
        $this->signature = $signature;
        parent::__construct();
    }
    /**
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $inputs = array_merge($input->getArguments(), $input->getOptions());
        $parameters = [];
        foreach((new ReflectionFunction($this->callback))->getParameters() as $parameter) {
            if(isset($inputs[$parameter->name])) {
                $parameters[$parameter->name] = $inputs[$parameter->name];
            }
        }
        return $this->laravel->call($this->callback->bindTo($this, $this), $parameters);
    }
    /**
     * @param  string $description
     * @return $this
     */
    public function describe($description) {
        $this->setDescription($description);
        return $this;
    }
}