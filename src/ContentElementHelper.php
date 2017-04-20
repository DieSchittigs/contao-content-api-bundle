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
        $moduleModel = ModuleModel::findByPk($element->module);
        $moduleClass = Module::findClass($moduleModel->type);
        $module = new $moduleClass($moduleModel, $column);

        $_module = Helper::toObj($moduleModel);
        $_module->compiledHTML = Helper::replaceHTML(@$module->generate());

        return $_module;
    }
}
