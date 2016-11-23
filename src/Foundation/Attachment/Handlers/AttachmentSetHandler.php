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
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function data()
    {
        return $this->settings->all()->toArray();
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            '修改设置失败！',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function execute(Request $request)
    {
        $this->settings->set('attachment.engine', $request->get('engine'));
        $this->settings->set('attachment.limit.file', $request->get('limit_file'));
        $this->settings->set('attachment.limit.image', $request->get('limit_image'));
        $this->settings->set('attachment.limit.video', $request->get('limit_video'));
        $this->settings->set('attachment.format.image', $request->get('allow_image'));
        $this->settings->set('attachment.format.catcher', $request->get('allow_catcher'));
        $this->settings->set('attachment.format.video', $request->get('allow_video'));
        $this->settings->set('attachment.format.file', $request->get('allow_file'));
        $this->settings->set('attachment.manager.image', $request->get('allow_manager_image'));
        $this->settings->set('attachment.manager.file', $request->get('allow_manager_file'));
        $this->settings->set('attachment.watermark', $request->get('allow_watermark'));

        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            '修改设置成功!',
        ];
    }
}