<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-15 13:51
 */
namespace Notadd\Foundation\Debug\Handlers;

use Illuminate\Contracts\Console\Kernel;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class PublishHandler.
 */
class PublishHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->container->make(Kernel::class)->call('vendor:publish', [
            '--force' => true,
        ]);
        $this->withCode(200)->withMessage('发布资源成功！');
    }
}
