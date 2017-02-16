<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-16 17:55
 */
namespace Notadd\Foundation\Navigation\Handlers\Group;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Foundation\Navigation\Models\Group;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * ArticleEditorHandler constructor.
     *
     * @param \Illuminate\Container\Container            $container
     * @param \Notadd\Foundation\Navigation\Models\Group $group
     * @param \Illuminate\Http\Request                   $request
     * @param \Illuminate\Translation\Translator         $translator
     *
     * @internal param \Notadd\Content\Models\Article $article
     */
    public function __construct(
        Container $container,
        Group $group,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = $group;
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
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.update.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $article = $this->model->newQuery()->find($this->request->input('id'));
        $article->update([
            'content' => $this->request->input('content'),
            'is_hidden' => $this->request->input('hidden'),
            'is_sticky' => $this->request->input('sticky'),
            'source_author' => $this->request->input('source.author'),
            'source_link' => $this->request->input('source.link'),
            'description' => $this->request->input('summary'),
            'keyword' => $this->request->input('tags'),
            'title' => $this->request->input('title'),
        ]);

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
            $this->translator->trans('content::article.update.success'),
        ];
    }
}
