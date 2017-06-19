<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-03 15:33
 */
namespace Notadd\Foundation\Extension\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class UpdateHandler.
 */
class UpdateHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * UpdateHandler constructor.
     *
     * @param \Illuminate\Container\Container               $container
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(Container $container, ExtensionManager $manager)
    {
        parent::__construct($container);
        $this->manager = $manager;
    }

    /**
     * Execute Handler.
     */
    public function execute()
    {
        $extension = $this->manager->get($this->request->input('name'));
        if ($extension && method_exists($provider = $extension->getEntry(), 'update') && call_user_func([
                $provider,
                'update',
            ])
        ) {
            $this->withCode(200)->withMessage('');
        } else {
            $this->withCode(500)->withError('');
        }
    }
}
