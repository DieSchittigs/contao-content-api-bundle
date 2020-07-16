<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Environment;
use Contao\Model\Collection;
use Contao\PageModel;

class PageUrls implements ContaoJsonSerializable
{
    public $languages;
    public function __construct(PageModel $page = null)
    {
        $this->languages = new \stdClass;
        if ($page) $this->addFromPage($page);
    }

    public function addFromPage(PageModel $page, array $customData = [])
    {
        $page->loadDetails();
        $this->languages->{$page->language} = (object) [
            'url' => $customData['url'] ?: $page->getFrontendUrl(),
            'urlAbsolute' => $customData['urlAbsolute'] ?: $page->getAbsoluteUrl(),
            'isFallback' => $customData['isFallback'] ?: $page->rootFallbackLanguage == $page->language,
        ];
        $this->languages->{$page->language}->activity = $this->getActivity($this->languages->{$page->language}->url);
        return $this->languages->{$page->language};
    }

    public function addFromPages(Collection $pages)
    {
        foreach ($pages as $page)
            $this->addFromPage($page);
    }

    public function combine(PageUrls $pageUrls)
    {
        foreach ($pageUrls->languages as $language => $urls) {
            $this->languages->{$language} = $urls;
        }
    }

    public function toJson(): ContaoJson
    {
        return new ContaoJson($this->languages);
    }

    private function getActivity($url)
    {
        $activity = 0;
        $curUrlParts = explode('/', Environment::get('request'));
        $urlParts = explode('/', $url);
        foreach ($curUrlParts as $i => $part) {
            if (!$urlParts[$i] || $urlParts[$i] != $part) break;
            $activity++;
        }
        return $activity;
    }
}
