<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 16:09
 */
namespace Notadd\Foundation\Attachment\Apis;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

class CdnApi extends Controller
{
    public function handle(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('attachment.cnd.default', $this->request->input('default'));
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }
}
