<?php

namespace DieSchittigs\ContaoContentApiBundle;

use DieSchittigs\ContaoContentApiBundle\PageApi;
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
        $pages = PageModel::findPublishedByPid($pageId, ['order' => 'sorting']);
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

    public static function getPage($url, $ignoreUnequalAlias = false)
    {
        $urlLanguage = Helper::urlToLanguage($url);
        if($url == '/' || $url == '/'.$urlLanguage.'/'){
            $rootId = Frontend::getRootPageFromUrl()->id;
            $rootPage = PageModel::findByIdOrAlias($rootId);
            $page = PageModel::findFirstPublishedByPid($rootId);
        } else {
            $urlAlias = Helper::urlToAlias($url);
            $pageAlias = Frontend::getPageIdFromUrl();
            if (!$pageAlias) {
                return null;
            }
            if (!$ignoreUnequalAlias && $urlAlias != $pageAlias) {
                return null;
            }
            $pages = PageModel::findPublishedByIdOrAlias($pageAlias);
            foreach($pages as $page){
                $page->loadDetails();
                if($page->language == $urlLanguage) break;
            }
        }
        if (!$page) {
            return;
        }
        Controller::setStaticUrls($page);
        $objPage = self::parsePage($page);

        $objHandler = new $GLOBALS['TL_PTY']['api']();

        // Backwards compatibility
        if (!method_exists($objHandler, 'getResponse')) {
            $Page = $objHandler->generate($objPage, true);
        } else {
            $Page = $objHandler->getResponse($objPage);
        }

        $objPage->articles = $Page['articles'];
        return $objPage;
    }
}
