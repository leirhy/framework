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
     * @return void
     */
    public function configure() {
        $this->setDescription('Show extension list.');
        $this->setName('extension:list');
    }
    /**
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function fire(ExtensionManager $manager) {
        $paths = $manager->getExtensionPaths();
        $list = new Collection();
        $settings = $this->container->make(SettingsRepository::class);
        $this->info('Extensions list:');
        $paths->transform(function($path, $key) use($list, $settings) {
            $list->push([
                $key,
                $path,
                $settings->get('extension.' . $key . '.installed') ? 'Yes' : 'No'
            ]);
        });
        $this->table($this->headers, $list->toArray());
    }
}