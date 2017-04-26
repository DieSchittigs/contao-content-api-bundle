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

class PageHelper
{
    public static function getSubPages($pageId)
    {
        $subPages = [];
        $pages = PageModel::findPublishedByPid($pageId);
        if (!$pages) {
            return $subPages;
        }
        foreach ($pages as $page) {
            $_page = static::parsePage($page, true, false);
            if ($page->subpages > 0) {
                $_page->subPages = static::getSubPages($page->id);
            }
            $subPages[] = (object) $_page;
        }
        return $subPages;
    }

    public static function parsePage($page, $includeSubPages = true, $includeParentPage = true)
    {
        $page->loadDetails();
        $_page = Helper::toObj($page);
        if ($includeParentPage && $page->pid) {
            $parentPage = PageModel::findOneById($page->pid);
            if($parentPage) $_page->parentPage = static::parsePage($parentPage, false, true);
        }
        if ($includeSubPages) {
            $_page->subPages = static::getSubPages($page->id, false, false);
        }
        $_page->url = Helper::replaceURL($page->getFrontendUrl());
        return $_page;
    }

    public static function getPage($url)
    {
        if($url == '/' || $url == '/'.Helper::defaultLang().'/'){
            $rootId = Frontend::getRootPageFromUrl()->id;
            $rootPage = PageModel::findByIdOrAlias($rootId);
            $page = PageModel::findFirstPublishedByPid($rootId);
        } else {
            $urlAlias = Helper::urlToAlias($url);
            $pageAlias = Frontend::getPageIdFromUrl();
            if (!$pageAlias) {
                return null;
            }
            if ($urlAlias != $pageAlias) {
                return null;
            }
            $page = PageModel::findByIdOrAlias($pageAlias);
        }
        if (!$page) {
            return;
        }
        Controller::setStaticUrls($page);
        $_page = self::parsePage($page);
        $_page->articles = ArticleHelper::pageArticles($page->id);
        return $_page;
    }
}
