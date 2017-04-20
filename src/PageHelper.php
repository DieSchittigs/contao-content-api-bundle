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
        $pages = PageModel::findPublishedSubpagesWithoutGuestsByPid($pageId);
        if (!$pages) {
            return;
        }
        foreach ($pages as $page) {
            $_page = static::parsePage($page);
            if ($page->subpages > 0) {
                $_page->subPages = static::getSubPages($page->id);
            }
            $subPages[] = (object) $_page;
        }
        return $subPages;
    }

    public static function parsePage($page, $includeSubPages = true, $includeParentPage = true)
    {
        $_page = Helper::toObj($page);
        if ($includeParentPage && $page->pid && $page->pid != 1) {
            $_page->parentPage = static::parsePage(PageModel::findOneById($page->pid), false, true);
        }
        if ($includeSubPages) {
            $_page->subPages = static::getSubPages($page->id, false, false);
        }
        return $_page;
    }

    public static function getPage($url)
    {
        $urlAlias = Helper::urlToAlias($url);
        $pageAlias = Frontend::getPageIdFromUrl();
        if (!$pageAlias) {
            return null;
        }
        if ($urlAlias != $pageAlias && $pageAlias != 'index') {
            return null;
        }
        $page = PageModel::findByIdOrAlias($pageAlias);
        if (!$page) {
            return;
        }
        Controller::setStaticUrls($page);
        $pageUrl = Controller::generateFrontendUrl($page->row());
        $_page = self::parsePage($page);
        $_page->articles = ArticleHelper::pageArticles($page->id);
        return $_page;
    }
}
