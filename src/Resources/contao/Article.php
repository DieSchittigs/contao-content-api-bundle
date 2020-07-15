<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ArticleModel;
use Contao\Controller;
use Contao\ModuleArticle;
use Contao\System;

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
    public function __construct($id, $url = null)
    {
        $this->model = ArticleModel::findById($id, ['published'], ['1']);
        if (!$this->model || !Controller::isVisibleElement($this->model)) {
            return $this->model = null;
        }
        $contentElements = ApiContentElement::findByPidAndTable($id, 'tl_article', $this->inColumn, $url);
        $this->content = ApiContentElement::stackWrappers($contentElements);
        
        if (System::getContainer()->getParameter('content_api_compile_html')) {
            $module = new ModuleArticle($this->model);
            $this->compiledHTML = $module->generate();
        }
    }

    /**
     * Gets article by parent page id.
     *
     * @param int $pid id of the page
     */
    public static function findByPageId($pid, $url = null)
    {
        $articles = new \stdClass();
        foreach (ArticleModel::findByPid($pid) as $article) {
            if (!isset($articles->{$article->inColumn})) {
                $articles->{$article->inColumn} = [];
            }
            $articles->{$article->inColumn}[] = new self($article->id, $url);
        }

        return $articles;
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
