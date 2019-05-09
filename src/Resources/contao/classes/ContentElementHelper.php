<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\PageModel;
use Contao\ContentElement;
use Contao\ModuleModel;
use Contao\Module;
use Contao\Form;
use Contao\FormModel;
use Contao\FormFieldModel;

class ContentElementHelper
{
    public static function module($content, $column = 'main')
    {
        $contentModuleClass = ContentElement::findClass($content->type);
        $element = new $contentModuleClass($content, $column);
        return ModuleHelper::get($element->module);
    }

    public static function form($content)
    {
        $formModel = Helper::toObj(FormModel::findById($content->form));
        if($formModel) $formModel->fields = Helper::toObj(FormFieldModel::findPublishedByPid($formModel->id));
        return $formModel;
    }
}
