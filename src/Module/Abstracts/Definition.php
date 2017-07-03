<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-07-01 14:33
 */
namespace Notadd\Foundation\Module\Abstracts;

use Illuminate\Support\Collection;

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
     * Entries for module.
     *
     * @return array
     */
    abstract public function entries();

    /**
     * Name of module.
     *
     * @return string
     */
    abstract public function name();

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
        $entries->each(function ($attributes, $entry) use ($scripts, $stylesheets) {
            $scripts->push([
                'entry'   => $entry,
                'scripts' => $attributes['scripts'],
                'type'    => $attributes['type'],
            ]);
            $stylesheets->push([
                'entry'       => $entry,
                'stylesheets' => $attributes['stylesheets'],
                'type'        => $attributes['type'],
            ]);
        });
        $data->put('entries', $entries->toArray());
        $data->put('name', $this->name());
        $data->put('scripts', $scripts->toArray());
        $data->put('stylesheets', $stylesheets->toArray());
    }

    /**
     * Version of module.
     *
     * @return string
     */
    abstract public function version();
}
