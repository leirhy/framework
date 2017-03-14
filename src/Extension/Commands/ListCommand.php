<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 10:50
 */
namespace Notadd\Foundation\Extension\Commands;

use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class ListCommand.
 */
class ListCommand extends Command
{
    /**
     * @var array
     */
    protected $headers = [
        'Extension Name',
        'Author',
        'Description',
        'Extension Path',
        'Entry',
        'Status',
    ];

    /**
     * Configure Command.
     */
    public function configure()
    {
        $this->setDescription('Show extension list.');
        $this->setName('extension:list');
    }

    /**
     * Command Handler.
     *
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fire(ExtensionManager $manager)
    {
        $extensions = $manager->getExtensions();
        $list = new Collection();
        $this->info('Extensions list:');
        $extensions->each(function (Extension $extension, $path) use ($list) {
            $data = collect(collect($extension->getAuthor())->first());
            $author = $data->get('name');
            $data->has('email') ? $author .= ' <' . $data->get('email') . '>' : null;
            $list->push([
                $extension->getName(),
                $author,
                $extension->getDescription(),
                $path,
                $extension->getEntry(),
                'Normal'
            ]);
        });
        $this->table($this->headers, $list->toArray());
    }
}
