<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\PageModel;

class SitemapHelper
{
    public static function getSitemap($lang = null)
    {
        if (!$lang) $lang = Helper::defaultLang();
        $sitemap = [];
        $rootPages = PageModel::findPublishedRootPages();
        foreach($rootPages as $rootPage){
            if($rootPage->language == $lang) break;
        }
        $rootPage->loadDetails();
        return PageHelper::getSubPages($rootPage->id);
    }
}
