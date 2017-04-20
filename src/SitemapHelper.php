<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\PageModel;

class SitemapHelper
{
    public static function getSitemap($rootIndex = 0)
    {
        $sitemap = [];
        $rootPage = PageModel::findPublishedRootPages()[$rootIndex];
        return PageHelper::getSubPages($rootPage->id);
    }
}
