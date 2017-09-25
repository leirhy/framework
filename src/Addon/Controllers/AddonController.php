<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:50
 */
namespace Notadd\Foundation\Addon\Controllers;

use Illuminate\Support\Collection;
use Notadd\Foundation\Addon\Addon;
use Notadd\Foundation\Addon\AddonManager;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ExtensionController.
 */
class AddonController extends Controller
{
    /**
     * @var \Notadd\Foundation\Addon\AddonManager
     */
    protected $manager;

    /**
     * AddonController constructor.
     *
     * @param \Notadd\Foundation\Addon\AddonManager $manager
     */
    public function __construct(AddonManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    public function list()
    {
        $enabled = $this->manager->repository()->enabled();
        $extensions = $this->manager->repository();
        $installed = $this->manager->repository()->installed();
        $notInstalled = $this->manager->repository()->notInstalled();

        return $this->response->json([
            'data'     => [
                'enabled'    => $this->info($enabled),
                'extensions' => $this->info($extensions),
                'installed'  => $this->info($installed),
                'notInstall' => $this->info($notInstalled),
            ],
            'messages' => '获取插件列表成功！',
        ]);
    }

    /**
     * Info list.
     *
     * @param \Illuminate\Support\Collection $list
     *
     * @return array
     */
    protected function info(Collection $list)
    {
        $data = collect();
        $list->each(function (Addon $extension) use ($data) {
            $data->put($extension->identification(), [
                'author'         => collect($extension->offsetGet('author'))->implode(','),
                'enabled'        => $extension->enabled(),
                'description'    => $extension->offsetGet('description'),
                'identification' => $extension->identification(),
                'name'           => $extension->offsetGet('name'),
            ]);
        });

        return $data->toArray();
    }
}
