<?php

namespace DieSchittigs\ContaoContentApiBundle;

use DieSchittigs\ContaoContentApiBundle\News\ModuleNewsList;
use Contao\ContentModel;
use Contao\StringUtil;

class Hooks
{
    public static function apiModuleGenerated(ApiModule $module, string $moduleClass)
    {
        if ($moduleClass != 'Contao\ModuleNewsList' && $moduleClass != 'ModuleNewsList') {
            return;
        }
        $_module = new ModuleNewsList($module->model, null);
        $module->newsItems = $_module->pFetchItems(
            StringUtil::deserialize($_module->news_archives),
            $module->news_featured == 'featured',
            $module->numberOfItems,
            0
        );
        foreach ($module->newsItems as $item) {
            if ($_module->imgSize && !trim(
                implode(
                    '',
                    StringUtil::deserialize($item->size)
                )
            )) $item->size = $_module->imgSize;
            $content = ContentModel::findPublishedByPidAndTable($item->id, 'tl_news');
            $item->showMore = (bool) $content;
        }
    }
}
