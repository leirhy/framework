<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-17 19:22
 */
namespace Notadd\Foundation\Attachment\Controllers;

use Notadd\Foundation\Attachment\Handlers\StorageSetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

class StorageController extends Controller
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * WatermarkController constructor.
     *
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(SettingsRepository $settings)
    {
        parent::__construct();
        $this->settings = $settings;
    }

    /**
     * TODO: Method handle Description
     *
     * @param \Notadd\Foundation\Attachment\Handlers\StorageSetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function handle(StorageSetHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}
