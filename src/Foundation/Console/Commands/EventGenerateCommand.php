<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:10
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Class EventGenerateCommand.
 */
class EventGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'event:generate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the missing events and listeners based on registration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $provider = $this->laravel->getProvider('Illuminate\Foundation\Support\Providers\EventServiceProvider');
        foreach ($provider->listens() as $event => $listeners) {
            if (!Str::contains($event, '\\')) {
                continue;
            }
            $this->callSilent('make:event', ['name' => $event]);
            foreach ($listeners as $listener) {
                $listener = preg_replace('/@.+$/', '', $listener);
                $this->callSilent('make:listener', [
                    'name'    => $listener,
                    '--event' => $event,
                ]);
            }
        }
        $this->info('Events and listeners generated successfully!');
    }
}
