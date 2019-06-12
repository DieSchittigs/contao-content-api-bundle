<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ModuleModel;
use Contao\Module;

/**
 * ApiModule augments ModuleModel for the API.
 *
 * @param int $id id of the ModuleModel
 */
class ApiModule extends AugmentedContaoModel
{
    public function __construct($id)
    {
        $this->model = ModuleModel::findByPk($id);
        $moduleClass = Module::findClass($this->type);
        try {
            $module = new $moduleClass($this->model, null);
            $this->compiledHTML = @$module->generate() ?? null;
        } catch (\Exception $e) {
            $this->compiledHTML = null;
        }
    }
}
