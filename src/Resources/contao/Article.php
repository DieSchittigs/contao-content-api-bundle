<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ArticleModel;
use Contao\Controller;
use Contao\ModuleArticle;

/**
 * ApiContentElement augments ArticleModel for the API.
 */
class Article extends AugmentedContaoModel
{
    public $content = [];
    /**
     * constructor.
     *
     * @param int $id id of the ArticleModel
     */
    public function __construct($id)
    {
        $this->model = ArticleModel::findById($id, ['published'], ['1']);
        if (!$this->model || !Controller::isVisibleElement($this->model)) {
            return $this->model = null;
        }
        $stack = [$this];
        $contentElements = ApiContentElement::findByPidAndTable($id, 'tl_article', $this->inColumn);
        foreach ($contentElements as $ce) {
            if (in_array($ce->type, $GLOBALS['TL_WRAPPERS']['stop'])) {
                if (count($stack) > 1) array_pop($stack);
                continue;
            }
            //print_r(get_class($stack[count($stack) - 1]));
            $stack[count($stack) - 1]->content[] = $ce;
            if (in_array($ce->type, $GLOBALS['TL_WRAPPERS']['start'])) {
                $stack[] = $ce;
            }
        }
        $module = new ModuleArticle($this->model);
        $this->compiledHTML = $module->generate();
    }

    /**
     * Gets article by parent page id.
     *
     * @param int $pid id of the page
     */
    public static function findByPageId($pid)
    {
        $articles = new \stdClass();
        foreach (ArticleModel::findByPid($pid) as $article) {
            if (!isset($articles->{$article->inColumn})) {
                $articles->{$article->inColumn} = [];
            }
            $articles->{$article->inColumn}[] = new self($article->id);
        }

        return $articles;
    }

    /**
     * Does this Article have a reader module?
     *
     * @param string $readerType What kind of reader? e.g. 'newsreader'
     */
    public function hasReader($readerType): bool
    {
        foreach ($this->content as $contentElement) {
            if ($contentElement->hasReader($readerType)) {
                return true;
            }
        }

        return false;
    }

    public function toJson(): ContaoJson
    {
        if (!$this->model) {
            return new ContaoJson(null);
        }
        $this->model->content = $this->content;

        return new ContaoJson($this->model);
    }
}
