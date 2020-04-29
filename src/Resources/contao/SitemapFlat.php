<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Config;

/**
 * SitemapFlat represents the actual site structure as a key value object.
 * Key: URL of the page
 * Value: PageModel.
 */
class SitemapFlat implements ContaoJsonSerializable
{
    public $sitemap;
    private $suffix;

    /**
     * constructor.
     *
     * @param string $language If set, ignores other languages
     */
    public function __construct(string $language = null)
    {
        $sitemap = new Sitemap($language);
        $this->sitemap = $sitemap->sitemapFlat;
        $this->suffix = Config::get('urlSuffix') ?? '';
    }

    private function removeSuffix($url)
    {
        if (!$this->suffix) return $url;
        return str_replace($this->suffix, '', $url);
    }

    public function findUrl($url, $exactMatch = true)
    {

        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }
        $url = \mb_strtolower($url);
        $page = $this->sitemap->{$url} ?? null;
        if ($page) {
            $page['exactUrlMatch'] = true;
            return $page;
        }
        if ($exactMatch) {
            return null;
        }
        $matches = [];
        foreach ($this->sitemap as $_url => $_page) {
            $_url = $this->removeSuffix($_url);
            if (substr($url, 0, strlen($_url)) === $_url) {
                $matches[$_url] = strlen($_url);
            }
        }
        if ($matches) {
            arsort($matches);
            return $this->sitemap->{\key($matches) . $this->suffix};
        }

        return null;
    }

    public function toJson(): ContaoJson
    {
        return new ContaoJson($this->sitemap);
    }
}
