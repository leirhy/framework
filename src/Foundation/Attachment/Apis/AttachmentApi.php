<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment\Apis;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class AttachmentApi.
 */
class AttachmentApi extends Controller
{
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('attachment.engine', $this->request->get('engine'));
        $settings->set('attachment.limit.file', $this->request->get('limit_file'));
        $settings->set('attachment.limit.image', $this->request->get('limit_image'));
        $settings->set('attachment.limit.video', $this->request->get('limit_video'));
        $settings->set('attachment.format.image', $this->request->get('allow_image'));
        $settings->set('attachment.format.catcher', $this->request->get('allow_catcher'));
        $settings->set('attachment.format.video', $this->request->get('allow_video'));
        $settings->set('attachment.format.file', $this->request->get('allow_file'));
        $settings->set('attachment.manager.image', $this->request->get('allow_manager_image'));
        $settings->set('attachment.manager.file', $this->request->get('allow_manager_file'));
        $settings->set('attachment.watermark', $this->request->get('allow_watermark'));
        dd($settings->all()->toArray());
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }

    /**
     * @return void
     */
    public function JKJK()
    {
    }
}
