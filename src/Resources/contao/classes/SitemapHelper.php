<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\PageModel;

class SitemapHelper
{
    public static function getSitemap($lang = null)
    {
        $sitemap = [];
        $rootPages = PageModel::findPublishedRootPages(['order' => 'sorting ASC']);
        foreach($rootPages as $rootPage){
            if($lang && $rootPage->language != $lang) continue;
            $rootPage->loadDetails();
            $sitemap = array_merge($sitemap, PageHelper::getSubPages($rootPage->id));
        }
        return $sitemap;
    }
}
