<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-03 15:27
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class UpdateHandler.
 */
class UpdateHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * UpdateHandler constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Notadd\Foundation\Module\ModuleManager $manager
     */
    public function __construct(Container $container, ModuleManager $manager)
    {
        parent::__construct($container);
        $this->manager = $manager;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $module = $this->manager->get($this->request->input('name'));
        if ($module && method_exists($provider = $module->getEntry(), 'update')) {
            return call_user_func([
                $provider,
                'update',
            ]);
        }

        return false;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}
