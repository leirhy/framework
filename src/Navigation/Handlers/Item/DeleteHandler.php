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
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Foundation\Navigation\Models\Item;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class DeleteHandler.
 */
class DeleteHandler extends SetHandler
{
    /**
     * CategoryDeleterHandler constructor.
     *
     * @param \Illuminate\Container\Container           $container
     * @param \Notadd\Foundation\Navigation\Models\Item $item
     * @param \Illuminate\Http\Request                  $request
     * @param \Illuminate\Translation\Translator        $translator
     */
    public function __construct(
        Container $container,
        Item $item,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
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
        return $this->model->structure($this->request->input('group_id'));
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::category.delete.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $category = $this->model->newQuery()->find($this->request->input('id'));
        if ($category === null) {
            return false;
        }
        $category->delete();

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::category.delete.success'),
        ];
    }
}
