<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-18 19:04
 */
namespace Notadd\Foundation\Mail\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class GetHandler.
 */
class GetHandler extends DataHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * GetHandler constructor.
     *
     * @param Container $container
     * @param SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
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
        return [
            'driver' => $this->settings->get('mail.driver', 'mail'),
            'encryption' => $this->settings->get('mail.encryption', 'none'),
            'port' => $this->settings->get('mail.port', '25'),
            'host' => $this->settings->get('mail.host', ''),
            'from' => $this->settings->get('mail.from', ''),
            'username' => $this->settings->get('mail.username', ''),
            'password' => $this->settings->get('mail.password', ''),
        ];
    }
}
