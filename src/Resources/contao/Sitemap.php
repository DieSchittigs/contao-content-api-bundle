<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\PageModel;

/**
 * Sitemap represents the actual site structure as an object tree.
 * The resulting instance can be iterated and used like an array.
 */
class Sitemap implements \IteratorAggregate, \ArrayAccess, \Countable, ContaoJsonSerializable
{
    protected $sitemap = [];
    public $sitemapFlat;

    /**
     * constructor.
     *
     * @param string $language If set, ignores other languages
     * @param int    $pid      Parent ID (for recursive calls)
     */
    public function __construct(string $language = null, $pid = null)
    {
        $this->sitemapFlat = new \stdClass();
        $pages = [];
        if (!$pid) {
            $pages = PageModel::findPublishedRootPages(['order' => 'sorting ASC', 'dns' => $_SERVER['HTTP_HOST']]);
        } else {
            $pages = PageModel::findPublishedByPid($pid, ['order' => 'sorting ASC']);
        }
        if (!$pages) {
            return;
        }
        foreach ($pages as $page) {
            $page->loadDetails();
            $page->url = $page->getFrontendUrl();
            $page->urlAbsolute = $page->getAbsoluteUrl();
            $subSitemap = new Sitemap($language, $page->id);
            if ($language && $page->language != $language) {
                continue;
            }
            if ($page->type == 'regular') {
                $this->sitemapFlat->{\mb_strtolower($page->url)} = $page->row();
            }
            foreach ($subSitemap->sitemapFlat as $_url => $_page) {
                $this->sitemapFlat->{\mb_strtolower($_url)} = $_page;
            }
            $page->subPages = $subSitemap;
            $this[] = $page;
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->sitemap);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->sitemap[$offset]);
    }

    public function offsetGet($offset): PageModel
    {
        return $this->sitemap[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (!$offset) {
            $this->sitemap[] = $value;
        } else {
            $this->sitemap[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->sitemap[$offset]);
    }

    public function count(): integer
    {
        return count($this->sitemap);
    }

    public function toJson(): ContaoJson
    {
        return new ContaoJson($this->sitemap);
    }
}
