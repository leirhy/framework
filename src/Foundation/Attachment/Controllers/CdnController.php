<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 16:09
 */
namespace Notadd\Foundation\Attachment\Controllers;

use Notadd\Foundation\Attachment\Handlers\CdnSetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class CdnApi.
 */
class CdnController extends Controller
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
     * Api handler.
     *
     * @param \Notadd\Foundation\Attachment\Handlers\CdnSetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function handle(CdnSetHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}
