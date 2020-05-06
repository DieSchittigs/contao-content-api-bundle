<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ModuleModel;
use Contao\Module;
use Contao\System;
use Contao\StringUtil;

/**
 * ApiModule augments ModuleModel for the API.
 */
class ApiModule extends AugmentedContaoModel
{
    public $article;
    /**
     * constructor.
     *
     * @param int $id id of the ModuleModel
     */
    public function __construct($id, $url = null)
    {
        $readers = System::getContainer()->getParameter('content_api_readers');
        $this->model = ModuleModel::findByPk($id);
        $moduleClass = Module::findClass($this->type);
        if (System::getContainer()->getParameter('content_api_compile_html')) {
            try {
                $strColumn = null;
                // Add compatibility to new front end module fragments
                if (defined('VERSION')) {
                    if (version_compare(VERSION, '4.5', '>=')) {
                        if ($moduleClass === \Contao\ModuleProxy::class) {
                            $strColumn = 'main';
                        }
                    }
                }
                $module = new $moduleClass($this->model, $strColumn);
                $this->compiledHTML = @$module->generate() ?? null;
            } catch (\Exception $e) {
                $this->compiledHTML = null;
            }
        }
        if ($url !== null) {
            foreach ($readers as $type => $model) {
                if ($this->type == $type) {
                    $this->article = new Reader($model, $url);
                    if ($this->imgSize && !trim(
                        implode(
                            '',
                            StringUtil::deserialize($this->article->size)
                        )
                    )) $this->article->size = $this->imgSize;
                }
            }
        }

        if (isset($GLOBALS['TL_HOOKS']['apiModuleGenerated']) && is_array($GLOBALS['TL_HOOKS']['apiModuleGenerated'])) {
            foreach ($GLOBALS['TL_HOOKS']['apiModuleGenerated'] as $callback) {
                $callback[0]::{$callback[1]}($this, $moduleClass);
            }
        }
    }
}
