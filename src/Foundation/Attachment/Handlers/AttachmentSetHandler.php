<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 16:08
 */
namespace Notadd\Foundation\Attachment\Handlers;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class AttachmentSetHandler.
 */
class AttachmentSetHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Illuminate\Http\Request                                $request
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     * @param \Illuminate\Translation\Translator                      $translator
     */
    public function __construct(
        Container $container,
        Request $request,
        SettingsRepository $settings,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->settings = $settings;
    }

    /**
     * TODO: Method data Description
     *
     * @return array
     */
    public function data()
    {
        return $this->settings->all()->toArray();
    }

    /**
     * TODO: Method errors Description
     *
     * @return array
     */
    public function errors()
    {
        return [
            '修改设置失败！',
        ];
    }

    /**
     * TODO: Method execute Description
     *
     * @return bool
     */
    public function execute()
    {
        $this->settings->set('attachment.engine', $this->request->get('engine'));
        $this->settings->set('attachment.limit.file', $this->request->get('limit_file'));
        $this->settings->set('attachment.limit.image', $this->request->get('limit_image'));
        $this->settings->set('attachment.limit.video', $this->request->get('limit_video'));
        $this->settings->set('attachment.format.image', $this->request->get('allow_image'));
        $this->settings->set('attachment.format.catcher', $this->request->get('allow_catcher'));
        $this->settings->set('attachment.format.video', $this->request->get('allow_video'));
        $this->settings->set('attachment.format.file', $this->request->get('allow_file'));
        $this->settings->set('attachment.manager.image', $this->request->get('allow_manager_image'));
        $this->settings->set('attachment.manager.file', $this->request->get('allow_manager_file'));
        $this->settings->set('attachment.watermark', $this->request->get('allow_watermark'));

        return true;
    }

    /**
     * TODO: Method messages Description
     *
     * @return array
     */
    public function messages()
    {
        return [
            '修改设置成功!',
        ];
    }
}
