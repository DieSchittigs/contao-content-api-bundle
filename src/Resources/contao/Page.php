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
    public $url;
    public $urlAbsolute;
    public $articles;
    public $layout;
    /**
     * constructor.
     *
     * @param int $id id of the PageModel
     */
    public function __construct($id, $url = null)
    {
        $this->model = PageModel::findById($id);
        if (!$this->model || !Controller::isVisibleElement($this->model)) {
            return $this->model = null;
        }
        $this->model->loadDetails();
        $this->url = $this->model->getFrontendUrl();
        $this->urlAbsolute = $this->model->getAbsoluteUrl();
        Controller::setStaticUrls($this->model);
        $this->articles = Article::findByPageId($this->id, $url);
        $this->layout = new Layout($this->model->layout);
    }

    public static function findByUrl($url, $exactMatch = true)
    {
        $sitemapFlat = new SitemapFlat();
        $_page = $sitemapFlat->findUrl($url, $exactMatch);
        if (!$_page) {
            throw new ContentApiNotFoundException('Page not found at URL ' . $url);
        }
        $page = new self($_page['id'], $url);
        $page->exactUrlMatch = $_page->exactUrlMatch;

        return $page;
    }
}
