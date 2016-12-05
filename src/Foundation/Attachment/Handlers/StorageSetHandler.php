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
class StorageSetHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Http\Request $request
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     * @param \Illuminate\Translation\Translator $translator
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
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->settings->set('storage.default', $this->request->get('default'));

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
