<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-21 18:12
 */
namespace Notadd\Foundation\Module\Commands;

use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleManager;

/**
 * Class ListCommand.
 */
class ListCommand extends Command
{
    /**
     * @var array
     */
    protected $headers = [
        'Module Name',
        'Author',
        'Description',
        'Module Path',
        'Entry',
        'Status',
    ];

    /**
     * Configure Command.
     */
    public function configure()
    {
        $this->setDescription('Show module list.');
        $this->setName('module:list');
    }

    /**
     * Command Handler.
     *
     * @param \Notadd\Foundation\Module\ModuleManager $manager
     *
     * @return bool
     */
    public function fire(ModuleManager $manager): bool
    {
        $modules = $manager->getModules();
        $list = new Collection();
        $this->info('Extensions list:');
        $modules->each(function (Module $module, $path) use ($list) {
            $list->push([
                $module->getIdentification(),
                collect($module->getAuthor())->first(),
                $module->getDescription(),
                $path,
                $module->getEntry(),
                'Normal'
            ]);
        });
        $this->table($this->headers, $list->toArray());
    }
}