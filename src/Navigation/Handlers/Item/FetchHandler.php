<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-16 17:56
 */
namespace Notadd\Foundation\Navigation\Handlers\Item;

use Illuminate\Container\Container;
use Notadd\Foundation\Navigation\Models\Item;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * CategoryFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container           $container
     * @param \Notadd\Foundation\Navigation\Models\Item $item
     */
    public function __construct(
        Container $container,
        Item $item
    ) {
        parent::__construct($container);
        $this->model = $item;
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $group = $this->request->input('group');

        return $this->model->structure($group);
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::category.fetch.fail'),
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::category.fetch.success'),
        ];
    }
}
