<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ModuleModel;
use Contao\Module;

class ModuleHelper
{
    public static function get($id)
    {
        $moduleModel = ModuleModel::findByPk($id);
        $moduleClass = Module::findClass($moduleModel->type);
        $module = new $moduleClass($moduleModel, $column);

        $_module = Helper::toObj($moduleModel);
        $_module->compiledHTML = Helper::replaceHTML(@$module->generate());

        return $_module;
    }
}
