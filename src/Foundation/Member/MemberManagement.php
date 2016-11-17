<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 16:12
 */
namespace Notadd\Foundation\Member;

use Illuminate\Container\Container;
use InvalidArgumentException;
use Notadd\Foundation\Member\Abstracts\Manager;

/**
 * Class MemberManagement.
 */
class MemberManagement
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var array
     */
    protected $drivers = [];
    /**
     * @var string
     */
    protected $default;
    /**
     * @var \Notadd\Foundation\Member\Abstracts\Manager
     */
    protected $manager;

    /**
     * MemberManagement constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $data
     * @param bool  $force
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function create(array $data, $force = false)
    {
        return $this->manager->create($data, $force);
    }

    /**
     * @param array $data
     * @param bool  $force
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function delete(array $data, $force = false)
    {
        return $this->manager->delete($data, $force);
    }

    /**
     * @param array $data
     * @param bool  $force
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function edit(array $data, $force = false)
    {
        return $this->manager->edit($data, $force);
    }

    /**
     * @param $key
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function find($key)
    {
        return $this->manager->find($key);
    }

    /**
     * @return \Notadd\Foundation\Member\Abstracts\Manager
     */
    public function manager()
    {
        return $this->manager;
    }

    /**
     * @param \Notadd\Foundation\Member\Abstracts\Manager $manager
     */
    public function registerManager(Manager $manager)
    {
        if (is_object($this->manager)) {
            throw new InvalidArgumentException('Member Manager has been Registered!');
        }
        if ($manager instanceof Manager) {
            $this->manager = $manager;
            $this->manager->init();
        } else {
            throw new InvalidArgumentException('Member Manager must be instanceof '.Manager::class.'!');
        }
    }

    /**
     * @param array $data
     * @param bool  $force
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function store(array $data, $force = false)
    {
        return $this->manager->store($data, $force);
    }

    /**
     * @param array $data
     * @param bool  $force
     *
     * @return \Notadd\Foundation\Member\Member
     */
    public function update(array $data, $force = false)
    {
        return $this->manager->update($data, $force);
    }
}
