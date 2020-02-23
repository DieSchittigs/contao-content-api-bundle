<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ModuleModel;
use Contao\Module;

/**
 * ApiModule augments ModuleModel for the API.
 */
class ApiModule extends AugmentedContaoModel
{
    /**
     * constructor.
     *
     * @param int $id id of the ModuleModel
     */
    public function __construct($id)
    {
        $this->model = ModuleModel::findByPk($id);
        $moduleClass = Module::findClass($this->type);
        try {
            $strColumn = null;
            // Add compatibility to new front end module fragments
            if(defined('VERSION'))
            {
                if (version_compare(VERSION, '4.5', '>='))
                {
                    if ($moduleClass === ModuleProxy::class)
                    {
                        $strColumn = 'main';
                    }
                }
            }
            $module = new $moduleClass($this->model, $strColumn);            
            $this->compiledHTML = @$module->generate() ?? null;
        } catch (\Exception $e) {
            $this->compiledHTML = null;
        }
        if (isset($GLOBALS['TL_HOOKS']['apiModuleGenerated']) && is_array($GLOBALS['TL_HOOKS']['apiModuleGenerated'])) {
            foreach ($GLOBALS['TL_HOOKS']['apiModuleGenerated'] as $callback) {
                $callback[0]::{$callback[1]}($this, $moduleClass);
            }
        }
    }
}
