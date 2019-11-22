<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Controller;
use Contao\Config;

/**
 * Reader augments reader model classes for the API.
 */
class Reader extends AugmentedContaoModel
{
    /**
     * constructor.
     *
     * @param string $model Reader Model class (e.g. NewsModel)
     * @param string $url   Current URL
     */
    public function __construct($model, $url)
    {
        $alias = $this->urlToAlias($url);
        $this->model = $model::findOneByAlias($alias);
        if (!$this->model || !Controller::isVisibleElement($this->model)) {
            return null;
        }
        $this->content = ApiContentElement::findByPidAndTable($this->id, $model::getTable());
    }

    /**
     * Gets the alias from a URL.
     *
     * @param string $url URL to get the alias from
     */
    private function urlToAlias($url)
    {
        while (substr($url, -1, 1) == '/') {
            $url = substr($url, 0, -1);
        }
        $alias = end(explode('/', $url));
        if ($suffix = Config::get('urlSuffix')) {
            $alias = str_replace($suffix, '', $alias);
        }

        return $alias;
    }
}
