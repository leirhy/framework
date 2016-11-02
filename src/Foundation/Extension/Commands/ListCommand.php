<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 10:50
 */
namespace Notadd\Foundation\Extension\Commands;
use Illuminate\Support\Collection;
use Notadd\Foundation\Composer\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
/**
 * Class ListCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class ListCommand extends Command {
    /**
     * @var array
     */
    protected $headers = [
        'Extension Name',
        'Extension Path',
        'Installed',
    ];
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;
    /**
     * InstallCommand constructor.
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(ExtensionManager $manager, SettingsRepository $settings) {
        parent::__construct();
        $this->manager = $manager;
        $this->settings = $settings;
    }
    /**
     * @return void
     */
    public function configure() {
        $this->setDescription('Show extension list.');
        $this->setName('extension:list');
    }
    /**
     * @return void
     */
    public function fire() {
        $paths = $this->manager->getExtensionPaths();
        $list = new Collection();
        $this->info('Extensions list:');
        $paths->transform(function($path, $key) use($list) {
            $list->push([
                $key,
                $path,
                $this->settings->get('extension.' . $key . '.installed') ? 'Yes' : 'No'
            ]);
        });
        $this->table($this->headers, $list->toArray());
    }
}