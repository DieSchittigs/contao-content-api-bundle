<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\PageModel;
use Contao\ContentElement;
use Contao\ModuleModel;
use Contao\Module;

class ContentElementHelper
{
    public static function module($content, $column = 'main')
    {
        $contentModuleClass = ContentElement::findClass($content->type);
        $element = new $contentModuleClass($content, $column);
        return ModuleHelper::get($element->module);
    }
}
