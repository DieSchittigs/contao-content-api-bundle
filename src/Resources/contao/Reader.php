<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Controller;
use Contao\Config;
use Contao\PageModel;

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

        // Try to get info from parent, maybe even a page
        $jumpToPage = null;
        if ($this->model->pid) {
            $this->parent = $this->model->getRelated('pid');
            if ($this->parent && $this->parent->jumpTo) {
                $jumpToPage = $this->parent->getRelated('jumpTo');
                $jumpToPage->loadDetails();
                $this->parent->url = $jumpToPage->getFrontendUrl();
                $this->parent->urlAbsolute = $jumpToPage->getAbsoluteUrl();
                $this->urlAbsolute = $this->injectAlias($this->parent->urlAbsolute, $this->model->alias);
            }
        }

        // Special case: Language Switcher (https://github.com/terminal42/contao-changelanguage)
        if (isset($this->model->languageMain)) {
            $this->languageUrls = [];
            if ($jumpToPage) {
                $this->languageUrls[$jumpToPage->language] = [
                    'url' => $this->injectAlias($this->parent->url, $this->model->alias),
                    'urlAbsolute' => $this->urlAbsolute,
                    'isFallback' => $jumpToPage->rootFallbackLanguage == $jumpToPage->language
                ];
            }
            $select = 'languageMain=?';
            $values = [$this->model->id];

            if ($this->model->languageMain != 0 && $this->model->languageMain != $this->model->id) {
                $select .= ' OR id=?';
                $values[] = $this->model->languageMain;
            }
            $items = $model::findBy([$select], $values);
            if ($items) {
                foreach ($items as $item) {
                    $url = null;
                    $urlAbsolute = null;
                    $language = null;
                    $isFallback = false;
                    if ($item->jumpTo) $url = $item->getRelated('jumpTo');
                    elseif ($item->pid) {
                        $parent = $item->getRelated('pid');
                        if ($parent->jumpTo) {
                            $jumpTo = $parent->getRelated('jumpTo');
                            $jumpTo->loadDetails();
                            $url = $jumpTo->getFrontendUrl();
                            $urlAbsolute = $jumpTo->getAbsoluteUrl();
                            $language = $jumpTo->language;
                            $isFallback = $jumpTo->rootFallbackLanguage == $jumpTo->language;
                        }
                    } else continue;

                    $this->languageUrls[$language] = [
                        'url' => $this->injectAlias($url, $item->alias),
                        'urlAbsolute' => $this->injectAlias($urlAbsolute, $item->alias),
                        'isFallback' => $isFallback
                    ];
                }
            }
        }

        $contentElements = ApiContentElement::findByPidAndTable($this->id, $model::getTable());
        $this->content = ApiContentElement::stackWrappers($contentElements);

        if ($this->content) {
            $GLOBALS['CONTENT_API_ACTIVE_READER'] = true;
        }
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

    /**
     * inserts an alias into an URL.
     *
     * @param string $url URL to insert the alias into
     * @param string $alias to insert
     */
    private function injectAlias($url, $alias)
    {
        if ($suffix = Config::get('urlSuffix')) {
            return str_replace($suffix, "/$alias$suffix", $url);
        }
        while (substr($url, -1, 1) == '/') {
            $url = substr($url, 0, -1);
        }
        return "$url/$alias";
    }
}
