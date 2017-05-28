<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-18 11:24
 */
namespace Notadd\Foundation\Attachment\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class AttachmentGetHandler.
 */
class AttachmentGetHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * AttachmentGetHandler constructor.
     *
     * @param Container          $container
     * @param SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->success()->withData([
            'canManagementImageExtension' => $this->settings->get('attachment.manager.image', '.png,.jpg,.jpeg,.gif,.bmp'),
            'canManagementFileExtension'  => $this->settings->get('attachment.manager.file', '.png,.jpg,.jpeg,.gif,.bmp,.flv,.swf,.mkv,.avi,.rm,.rmvb,.mpeg,.mpg,.ogg,.ogv,.mov,.wmv,.mp4,.webm,.mp3,.wav,.mid,.rar,.zip,.tar,.gz,.7z,.bz2,.cab,.iso,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.txt,.md,.xml'),
            'canUploadImageExtension'     => $this->settings->get('attachment.format.image', '.png,.jpg,.jpeg,.gif,.bmp'),
            'canUploadCatcherExtension'   => $this->settings->get('attachment.format.catcher', '.png,.jpg,.jpeg,.gif,.bmp'),
            'canUploadVideoExtension'     => $this->settings->get('attachment.format.video', '.flv,.swf,.mkv,.avi,.rm,.rmvb,.mpeg,.mpg,.ogg,.ogv,.mov,.wmv,.mp4,.webm,.mp3,.wav,.mid'),
            'canUploadFileExtension'      => $this->settings->get('attachment.format.file', '.png,.jpg,.jpeg,.gif,.bmp,.flv,.swf,.mkv,.avi,.rm,.rmvb,.mpeg,.mpg,.ogg,.ogv,.mov,.wmv,.mp4,.webm,.mp3,.wav,.mid,.rar,.zip,.tar,.gz,.7z,.bz2,.cab,.iso,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.txt,.md,.xml'),
            'fileMaxSize'                 => $this->settings->get('attachment.limit.file', 2048),
            'imageMaxSize'                => $this->settings->get('attachment.limit.image', 2048),
            'imageProcessingEngine'       => $this->settings->get('attachment.engine', 'gd'),
            'videoMaxSize'                => $this->settings->get('attachment.limit.video', 2048),
        ])->withMessage('获取附件配置成功！');
    }
}
