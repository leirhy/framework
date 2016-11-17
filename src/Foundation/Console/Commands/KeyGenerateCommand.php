<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:13
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class KeyGenerateCommand.
 */
class KeyGenerateCommand extends Command
{
    /**
     * @var string
     */
    protected $description = 'Set the application key';
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $laravel;
    /**
     * @var string
     */
    protected $signature = 'key:generate {--show : Display the key instead of modifying files}';

    /**
     * @return bool
     */
    public function fire()
    {
        $key = $this->generateRandomKey();
        if ($this->option('show')) {
            $this->line('<comment>'.$key.'</comment>');

            return false;
        }
        $this->setKeyInEnvironmentFile($key);
        $this->laravel['config']['app.key'] = $key;
        $this->info("Application key [$key] set successfully.");

        return true;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    protected function setKeyInEnvironmentFile($key)
    {
        $path = $this->laravel->environmentFilePath();
        if (file_exists($path)) {
            file_put_contents($path, str_replace('APP_KEY='.$this->laravel['config']['app.key'], 'APP_KEY='.$key, file_get_contents($path)));
        } else {
            touch($path);
            file_put_contents($path, 'APP_KEY='.$key);
        }
    }

    /**
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(random_bytes($this->laravel['config']['app.cipher'] == 'AES-128-CBC' ? 16 : 32));
    }
}
