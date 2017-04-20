<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\PageModel;
use Contao\ArticleModel;
use Contao\FilesModel;
use Contao\ContentModel;
use Contao\Frontend;
use Contao\Model;
use Contao\Controller;
use Contao\ModuleArticle;

class ArticleHelper
{
    public static function pageArticles($pageId)
    {
        $articles = new \stdClass;
        foreach (ArticleModel::findByPid($pageId) as $article) {
            if (!Controller::isVisibleElement($article)) {
                continue;
            }
            if (!array_key_exists($article->inColumn, $articles)) {
                $articles->{$article->inColumn} = [];
            }
            $_article = Helper::toObj($article);
            $contents = ContentModel::findPublishedByPidAndTable($article->id, 'tl_article');
            if (!$contents) {
                continue;
            }
            foreach ($contents as $content) {
                if (!Controller::isVisibleElement($content)) {
                    continue;
                }
                if ($content->type === 'module') {
                    $content->subModule = ContentElementHelper::module($content, $article->inColumn);
                }
                $_article->content[] = Helper::toObj($content);
            }
            $module = new ModuleArticle($article);
            $_article->compiledHTML = Helper::replaceHTML(@$module->generate());
            $articles->{$article->inColumn}[] = $_article;
        }
        return $articles;
    }
}
