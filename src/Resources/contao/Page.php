<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\PageModel;
use Contao\Controller;
use DieSchittigs\ContaoContentApiBundle\Exceptions\ContentApiNotFoundException;

/**
 * Page augments PageModel for the API.
 */
class Page extends AugmentedContaoModel
{
    /**
     * constructor.
     *
     * @param int $id id of the PageModel
     */
    public function __construct($id)
    {
        $this->model = PageModel::findById($id);
        if (!$this->model || !Controller::isVisibleElement($this->model)) {
            return $this->model = null;
        }
        $this->model->loadDetails();
        $this->url = $this->model->getFrontendUrl();
        $this->urlAbsolute = $this->model->getAbsoluteUrl();
        Controller::setStaticUrls($this->model);
        $this->articles = Article::findByPageId($this->id);
    }

    public static function findByUrl($url, $exactMatch = true)
    {
        $sitemapFlat = new SitemapFlat();
        $_page = $sitemapFlat->findUrl($url, $exactMatch);
        if (!$_page) {
            throw new ContentApiNotFoundException('Page not found at URL '.$url);
        }
        $page = new self($_page['id']);
        $page->exactUrlMatch = $_page->exactUrlMatch;

        return $page;
    }

    /**
     * Does this Page have a reader module?
     *
     * @param string $readerType What kind of reader? e.g. 'newsreader'
     */
    public function hasReader($readerType): bool
    {
        foreach ($this->articles as $articles) {
            foreach ($articles as $article) {
                if ($article->hasReader($readerType)) {
                    return true;
                }
            }
        }

        return false;
    }
}
