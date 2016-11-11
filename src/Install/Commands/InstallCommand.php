<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-26 16:58
 */
namespace Notadd\Install\Commands;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use PDO;
/**
 * Class InstallCommand
 * @package Notadd\Install\Commands
 */
class InstallCommand extends Command {
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $data;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;
    /**
     * @var bool
     */
    protected $isDataSetted = false;
    /**
     * InstallCommand constructor.
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Filesystem $files, Repository $config) {
        parent::__construct();
        $this->config = $config;
        $this->data = new Collection();
        $this->filesystem = $files;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->setDescription('Run notadd\'s installation migration and seeds');
        $this->setName('install');
    }
    /**
     * @return void
     */
    protected function createAdministrationUser() {
        $user = Member::create(['name' => $this->data->get('admin_account'), 'email' => $this->data->get('admin_email'), 'password' => bcrypt($this->data->get('admin_password')),]);
        if($this->container->bound('request')) {
            $this->container->make('auth')->login($user);
        }
    }
    /**
     * @return void
     */
    public function fire() {
        if(!$this->isDataSetted) {
            $this->setDataFromConsoling();
        }
        $this->config->set('database', ['fetch' => PDO::FETCH_OBJ, 'default' => $this->data->get('driver'), 'connections' => [], 'redis' => [],]);
        switch($this->data->get('driver')) {
            case 'mysql':
                $this->config->set('database.connections.mysql', ['driver' => 'mysql', 'host' => $this->data->get('database_host'), 'database' => $this->data->get('database'), 'username' => $this->data->get('database_username'), 'password' => $this->data->get('database_password'), 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci', 'prefix' => $this->data->get('database_prefix'), 'strict' => true, 'engine' => null,]);
                break;
            case 'pgsql':
                $this->config->set('database.connections.pgsql', ['driver' => 'pgsql', 'host' => $this->data->get('database_host'), 'database' => $this->data->get('database'), 'username' => $this->data->get('database_username'), 'password' => $this->data->get('database_password'), 'charset' => 'utf8', 'prefix' => $this->data->get('database_prefix'), 'schema' => 'public', 'sslmode' => 'prefer',]);
                break;
            case 'sqlite':
                $this->config->set('database.connections.sqlite', ['driver' => 'sqlite', 'database' => $this->container->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'database.sqlite', 'prefix' => $this->data->get('database_prefix'),]);
                touch($this->container->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'database.sqlite');
                break;
        }
        $this->call('migrate', ['--force' => true, '--path' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', database_path('migrations'))]);
        $this->call('passport:keys');
        $this->call('passport:client', ['--password' => true, '--name' => 'Notadd Administrator Client']);
        $setting = $this->container->make(SettingsRepository::class);
        $setting->set('site.name', $this->data->get('website'));
        $setting->set('setting.image.engine', 'webp');
        if($this->data->get('image_engine', false)) {
        } else {
            $setting->set('setting.image.engine', 'normal');
        }
        $this->createAdministrationUser();
        $this->writingConfiguration();
        $this->call('key:generate');
        $this->info('Notadd Installed!');
    }
    /**
     * @return void
     */
    public function setDataFromConsoling() {
        $this->data->put('driver', $this->ask('数据库引擎(mysql/pgsql/sqlite)：'));
        if(in_array($this->data->get('driver'), ['mysql', 'pgsql'])) {
            $this->data->put('database_host', $this->ask('数据库服务器：'));
            $this->data->put('database', $this->ask('数据库名：'));
            $this->data->put('database_username', $this->ask('数据库用户名：'));
            $this->data->put('database_password', $this->ask('数据库密码：'));
        }
        $this->data->put('database_prefix', $this->ask('数据库表前缀：'));
        $this->data->put('admin_account', $this->ask('管理员帐号：'));
        $this->data->put('admin_password', $this->ask('管理员密码：'));
        $this->data->put('admin_password_confirmation', $this->ask('重复密码：'));
        $this->data->put('admin_email', $this->ask('电子邮箱：'));
        $this->data->put('website', $this->ask('网站标题：'));
        $this->data->put('image_engine', $this->ask('是否开启Webp图片模式(on)：'));
        $this->info('所填写的信息是：');
        $this->info('数据库引擎：' . $this->data->get('driver'));
        if(in_array($this->data->get('driver'), ['mysql', 'pgsql'])) {
            $this->info('数据库服务器：' . $this->data->get('database_host'));
            $this->info('数据库名：' . $this->data->get('database'));
            $this->info('数据库用户名：' . $this->data->get('database_username'));
            $this->info('数据库密码：' . $this->data->get('database_password'));
        }
        $this->info('数据库表前缀：' . $this->data->get('database_prefix'));
        $this->info('管理员帐号：' . $this->data->get('admin_account'));
        $this->info('管理员密码：' . $this->data->get('admin_password'));
        $this->info('重复密码：' . $this->data->get('admin_password_confirmation'));
        $this->info('电子邮箱：' . $this->data->get('admin_email'));
        $this->info('网站标题：' . $this->data->get('website'));
        $this->info('是否开启Webp图片模式：' . $this->data->get('image_engine') == 'on' ? '开启' : '关闭');
        $this->isDataSetted = true;
    }
    /**
     * @param array $data
     */
    public function setDataFromController(array $data) {
        $this->data->put('image_engine', $data['image_engine']);
        $this->data->put('driver', $data['driver']);
        $this->data->put('database_host', $data['database_host']);
        $this->data->put('database', $data['database']);
        $this->data->put('database_username', $data['database_username']);
        $this->data->put('database_password', $data['database_password']);
        $this->data->put('database_prefix', $data['database_prefix']);
        $this->data->put('admin_account', $data['admin_account']);
        $this->data->put('admin_password', $data['admin_password']);
        $this->data->put('admin_password_confirmation', $data['admin_password_confirmation']);
        $this->data->put('admin_email', $data['admin_email']);
        $this->data->put('website', $data['website']);
        $this->isDataSetted = true;
    }
    /**
     * @return void
     */
    protected function writingConfiguration() {
        $config = ['fetch' => PDO::FETCH_OBJ, 'default' => $this->data->get('driver'), 'connections' => [], 'migrations' => 'migrations', 'redis' => [],];
        switch($this->data->get('driver')) {
            case 'mysql':
                $config['connections']['mysql'] = ['driver' => 'mysql', 'host' => $this->data->get('database_host'), 'database' => $this->data->get('database'), 'username' => $this->data->get('database_username'), 'password' => $this->data->get('database_password'), 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci', 'prefix' => $this->data->get('database_prefix'), 'strict' => false, 'engine' => null,];
                break;
            case 'pgsql':
                $config['connections']['pgsql'] = ['driver' => 'pgsql', 'host' => $this->data->get('database_host'), 'database' => $this->data->get('database'), 'username' => $this->data->get('database_username'), 'password' => $this->data->get('database_password'), 'charset' => 'utf8', 'prefix' => $this->data->get('database_prefix'), 'schema' => 'public', 'sslmode' => 'prefer',];
                break;
            case 'sqlite':
                $config['connections']['sqlite'] = ['driver' => 'sqlite', 'database' => $this->container->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'database.sqlite', 'prefix' => $this->data->get('database_prefix'),];
                break;
        }
        file_put_contents($this->container->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'replace.php', '<?php return ' . var_export($config, true) . ';');
    }
}