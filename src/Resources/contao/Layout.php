<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\LayoutModel;
use Contao\StringUtil;

/**
 * Layout augments LayoutModel for the API.
 */
class Layout extends AugmentedContaoModel
{
    public $modules;
    public $theme;
    /**
     * constructor.
     *
     * @param int $id id of the LayoutModel
     */
    public function __construct($id, $url = null)
    {
        $this->model = LayoutModel::findById($id);
        if (!$this->model) {
            return $this->model = null;
        }
        $this->theme = $this->model->getRelated('pid');
        $modules = StringUtil::deserialize($this->model->modules);
        foreach ($modules as $i => $module) {
            if (!$module['enable'] || $module['mod'] == 0) continue;
            if (!isset($this->modules[$module['col']])) $this->modules[$module['col']] = [];
            $this->modules[$module['col']][] = new ApiModule($module['mod']);
        }
    }
}
