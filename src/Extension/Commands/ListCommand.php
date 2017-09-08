<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
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
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(ExtensionManager $manager)
    {
        $extensions = $manager->getExtensions();
        $list = new Collection();
        $this->info('Extensions list:');
        $extensions->each(function (Extension $extension) use ($list) {
            $data = collect(collect($extension->getAuthor())->first());
            $author = $data->get('name');
            $data->has('email') ? $author .= ' <' . $data->get('email') . '>' : null;
            $list->push([
                $extension->identification(),
                $author,
                $extension->getDescription(),
                $extension->getPath(),
                $extension->getEntry(),
                'Normal',
            ]);
        });
        $this->table($this->headers, $list->toArray());

        return true;
    }
}
