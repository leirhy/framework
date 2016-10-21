<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:13
 */
namespace Notadd\Foundation\Console;
use Illuminate\Console\Command;
/**
 * Class KeyGenerateCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class KeyGenerateCommand extends Command {
    /**
     * @var string
     */
    protected $signature = 'key:generate {--show : Display the key instead of modifying files}';
    /**
     * @var string
     */
    protected $description = 'Set the application key';
    /**
     * @return void
     */
    public function fire() {
        $key = $this->generateRandomKey();
        if($this->option('show')) {
            return $this->line('<comment>' . $key . '</comment>');
        }
        $this->setKeyInEnvironmentFile($key);
        $this->laravel['config']['app.key'] = $key;
        $this->info("Application key [$key] set successfully.");
    }
    /**
     * @param  string $key
     * @return void
     */
    protected function setKeyInEnvironmentFile($key) {
        file_put_contents($this->laravel->environmentFilePath(), str_replace('APP_KEY=' . $this->laravel['config']['app.key'], 'APP_KEY=' . $key, file_get_contents($this->laravel->environmentFilePath())));
    }
    /**
     * @return string
     */
    protected function generateRandomKey() {
        return 'base64:' . base64_encode(random_bytes($this->laravel['config']['app.cipher'] == 'AES-128-CBC' ? 16 : 32));
    }
}