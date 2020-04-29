<?php

namespace DieSchittigs\ContaoContentApiBundle;

use DieSchittigs\ContaoContentApiBundle\News\ModuleNewsList;
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
        if ($_module->imgSize) {
            foreach ($module->newsItems as $item) {
                if (trim(
                    implode(
                        '',
                        StringUtil::deserialize($item->size)
                    )
                )) $item->size = $_module->imgSize;
            }
        }
    }
}
