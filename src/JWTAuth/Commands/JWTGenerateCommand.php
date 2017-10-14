<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-14 17:02
 */
namespace Notadd\Foundation\JWTAuth\Commands;

use Illuminate\Support\Str;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Yaml;

/**
 * Class JWTGenerateCommand.
 */
class JWTGenerateCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->addOption(
            'show',
            null,
            InputOption::VALUE_NONE,
            'Simply display the key instead of modifying files.'
        );
        $this->setDescription('Set the JWTAuth secret key used to sign the tokens');
        $this->setName('jwt:generate');
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        $key = Str::random(32);

        if ($this->input->getOption('show')) {
            return $this->output->writeln('<comment>'.$key.'</comment>');
        }

        $file = $this->container->environmentFilePath();
        $this->file->exists($file) || touch($file);

        $data = collect(Yaml::parse($this->file->get($file)));
        $data->put('JWT_SECRET', $key);
        $this->file->put($file, Yaml::dump($data->toArray()));

        $this->container['config']['jwt.secret'] = $key;

        return $this->output->writeln("<info>jwt-auth secret [$key] set successfully.</info>");
    }
}
