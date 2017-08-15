<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-07-01 14:33
 */
namespace Notadd\Foundation\Module\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Permission\PermissionManager;

/**
 * Class Definition.
 */
abstract class Definition
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $entries;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $scripts;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $stylesheets;

    /**
     * Definition constructor.
     */
    public function __construct()
    {
        $this->entries = new Collection();
        $this->scripts = new Collection();
        $this->stylesheets = new Collection();
    }

    /**
     * Description of module.
     *
     * @return string
     */
    abstract public function description();

    /**
     * Requires of module.
     *
     * @return array
     */
    abstract public function requires();

    /**
     * Resolve definition.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolve(Collection $data)
    {
        $entries = new Collection();
        $scripts = new Collection();
        $stylesheets = new Collection();
        $entryTypes = collect($this->entries());
        $entryTypes->each(function ($data, $type) use ($entries) {
            foreach ($data as $key => $entry) {
                $entry['type'] = $type;
                $entries->put($key, $entry);
            }
        });
        $entries->each(function ($attributes, $entry) use ($entries, $scripts, $stylesheets) {
            if ($this->checkPermission($attributes['permissions'])) {
                $scripts->put($entry, [
                    'entry'   => $entry,
                    'scripts' => $attributes['scripts'],
                    'type'    => $attributes['type'],
                ]);
                $stylesheets->put($entry, [
                    'entry'       => $entry,
                    'stylesheets' => $attributes['stylesheets'],
                    'type'        => $attributes['type'],
                ]);
            } else {
                $entries->offsetUnset($entry);
            }
        });
        $data->put('entries', $entries->toArray());
        $data->put('name', $this->name());
        $data->put('scripts', $scripts->toArray());
        $data->put('stylesheets', $stylesheets->toArray());
        $data->put('version', $this->version());
    }

    /**
     * Entries for module.
     *
     * @return array
     */
    abstract public function entries();

    /**
     * @param $identification
     *
     * @return bool
     */
    protected function checkPermission($identification)
    {
        if (!$identification) {
            return true;
        }
        $user = Container::getInstance()->make(Factory::class)->guard('api')->user();
        if ((!$user instanceof Model) || (!Member::hasMacro('groups'))) {
            return false;
        }
        foreach (collect($user->load('groups')->getAttribute('groups'))->toArray() as $group) {
            if (Container::getInstance()->make(PermissionManager::class)->check($identification, $group['identification'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Name of module.
     *
     * @return string
     */
    abstract public function name();

    /**
     * Setting data definition.
     *
     * @return array
     */
    abstract public function settings();

    /**
     * Version of module.
     *
     * @return string
     */
    abstract public function version();
}
