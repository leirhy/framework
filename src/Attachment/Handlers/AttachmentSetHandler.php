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
     * AttachmentSetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(
        Container $container,
        SettingsRepository $settings
    ) {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return $this->settings->all()->toArray();
    }

    /**
     * Errors for handler.
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
     * Execute Handler.
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
     * Messages for handler.
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
