<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-04 10:53
 */
namespace Notadd\Foundation\SearchEngine;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\View\Factory;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class Optimization.
 */
class Optimization
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    private $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $code;

    /**
     * @var \Notadd\Foundation\SearchEngine\Meta
     */
    private $meta;

    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    private $settings;

    /**
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Optimization constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     * @param \Illuminate\View\Factory                                $view
     */
    public function __construct(Container $container, SettingsRepository $settings, Factory $view)
    {
        $this->container = $container;
        $this->view = $view;
        $this->code = new Collection();
        $this->meta = new Meta();
        $this->settings = $settings;
        $this->code->put('{sitename}', $this->settings->get('seo.title', 'Notadd CMS'));
        $this->code->put('{keywords}', $this->settings->get('seo.keyword', 'Notadd CMS'));
        $this->code->put('{description}', $this->settings->get('seo.description', 'Notadd CMS'));
    }

    /**
     * Get all data or data by key.
     *
     * @param string $key
     *
     * @return \Illuminate\Support\Collection|mixed
     */
    public function getData($key = '')
    {
        $data = $this->meta->getData();
        foreach ($data as $k => $v) {
            $data->put($k, strip_tags(trim(strtr($v, $this->code->toArray()), '-_ ')));
        }
        if ($key) {
            return $data->get($key);
        } else {
            return $data;
        }
    }

    /**
     * Set code.
     *
     * @param $key
     * @param $value
     */
    public function setCode($key, $value)
    {
        $this->code->put($key, $value);
    }

    /**
     * Set custom meta.
     *
     * @param $title
     * @param $description
     * @param $keywords
     */
    public function setCustomMeta($title, $description, $keywords)
    {
        if ($title || $keywords || $description) {
            $this->meta->setTitle($title);
            $this->meta->setDescription($description);
            $this->meta->setKeywords($keywords);
        }
    }

    /**
     * Set title meta.
     *
     * @param $title
     */
    public function setTitleMeta($title)
    {
        $this->meta->setTitle($title);
    }

    /**
     * Set description meta.
     *
     * @param $description
     */
    public function setDescriptionMeta($description)
    {
        $this->meta->setDescription($description);
    }

    /**
     * Set keywords mets.
     *
     * @param $keywords
     */
    public function setKeywordsMeta($keywords)
    {
        $this->meta->setKeywords($keywords);
    }
}
