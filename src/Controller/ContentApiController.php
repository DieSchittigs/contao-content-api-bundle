<?php

namespace DieSchittigs\ContaoContentApiBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use DieSchittigs\ContaoContentApiBundle\File;
use DieSchittigs\ContaoContentApiBundle\ApiModule;
use DieSchittigs\ContaoContentApiBundle\ContentApiResponse;
use DieSchittigs\ContaoContentApiBundle\Sitemap;
use DieSchittigs\ContaoContentApiBundle\SitemapFlat;
use DieSchittigs\ContaoContentApiBundle\Page;
use DieSchittigs\ContaoContentApiBundle\Reader;
use DieSchittigs\ContaoContentApiBundle\UrlHelper;
use DieSchittigs\ContaoContentApiBundle\TextHelper;
use Symfony\Component\HttpFoundation\Request;
use Contao\System;
use Contao\Config;
use DieSchittigs\ContaoContentApiBundle\Exceptions\ContentApiNotFoundException;
use DieSchittigs\ContaoContentApiBundle\ApiUser;

/**
 * ContentApiController provides all routes.
 *
 * @Route("/api", defaults={"_scope" = "frontend", "_token_check" = false})
 */
class ContentApiController extends Controller
{
    private $apiUser;
    private $lang = null;

    /**
     * Called at the begin of every request.
     *
     * @param Request $request Current request
     *
     * @return Request
     */
    private function init(Request $request): Request
    {
        // Commit die if disabled
        if (!$this->getParameter('content_api_enabled')) {
            die('Content API is disabled');
        }
        $this->headers = $this->getParameter('content_api_headers');
        if (isset($GLOBALS['TL_HOOKS']['apiBeforeInit']) && is_array($GLOBALS['TL_HOOKS']['apiBeforeInit'])) {
            foreach ($GLOBALS['TL_HOOKS']['apiBeforeInit'] as $callback) {
                $request = $callback[0]::{$callback[1]}($request);
            }
        }
        // Override $_SERVER['REQUEST_URI']
        $_SERVER['REQUEST_URI'] = $request->query->get('url', $_SERVER['REQUEST_URI']);
        // Set the language
        if ($request->query->has('lang')) {
            $this->lang = $request->query->get('lang');
        } elseif (Config::get('addLanguageToUrl') && $request->query->has('url')) {
            $url = $request->query->get('url');
            if (substr($url, 0, 1) != '/') {
                $url = "/$url";
            }
            $urlParts = explode('/', $url);
            $this->lang = count($urlParts) > 1 && strlen($urlParts[1]) == 2 ? $urlParts[1] : null;
        }
        if (!$this->lang) {
            $sitemap = new Sitemap();
            foreach ($sitemap as $rootPage) {
                if ($rootPage->fallback) {
                    $this->lang = $rootPage->language;
                    break;
                }
            }
        }
        if ($this->lang) {
            $GLOBALS['TL_LANGUAGE'] = $this->lang;
            $_SESSION['TL_LANGUAGE'] = $this->lang;
            System::loadLanguageFile('default', $this->lang);
        }
        // Initialize Contao
        $this->container->get('contao.framework')->initialize();
        $this->apiUser = new ApiUser();
        if (!defined('BE_USER_LOGGED_IN')) {
            define('BE_USER_LOGGED_IN', false);
        }
        if (isset($GLOBALS['TL_HOOKS']['apiAfterInit']) && is_array($GLOBALS['TL_HOOKS']['apiAfterInit'])) {
            foreach ($GLOBALS['TL_HOOKS']['apiAfterInit'] as $callback) {
                $request = $callback[0]::$callback[1]($request);
            }
        }

        return $request;
    }

    /**
     * @return Response
     *
     * @Route("/sitemap", name="content_api_sitemap")
     *
     * @param Request $request Current request
     */
    public function sitemapAction(Request $request)
    {
        $request = $this->init($request);
        $sitemap = new Sitemap($request->query->get('lang', null));

        return new ContentApiResponse($sitemap, 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/sitemap/flat", name="content_api_sitemap_flat")
     *
     * @param Request $request Current request
     */
    public function sitemapFlatAction(Request $request)
    {
        $request = $this->init($request);

        return new ContentApiResponse(new SitemapFlat($request->query->get('lang', null)), 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/page", name="content_api_page")
     *
     * @param Request $request Current request
     */
    public function pageAction(Request $request)
    {
        $request = $this->init($request);
        try {
            return new ContentApiResponse(Page::findByUrl($request->query->get('url', null)), 200, $this->headers);
        } catch (ContentApiNotFoundException $e) {
            return new ContentApiResponse($e, 404);
        }
    }

    /**
     * @return Response
     *
     * @Route("/user", name="content_api_user")
     *
     * @param Request $request Current request
     */
    public function userAction(Request $request)
    {
        $request = $this->init($request);

        return new ContentApiResponse($this->apiUser, 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/text", name="content_api_text")
     *
     * @param Request $request Current request
     */
    public function textAction(Request $request)
    {
        $request = $this->init($request);

        return new ContentApiResponse(TextHelper::get(
            explode(',', $request->query->get('file', 'default')),
            $this->lang
        ), 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/file", name="content_api_file")
     *
     * @param Request $request Current request
     */
    public function fileAction(Request $request)
    {
        $request = $this->init($request);

        return new ContentApiResponse(
            File::get($request->query->get('path', 'files'), $request->query->get('depth', 0)), 200, $this->headers
        );
    }

    /**
     * @return Response
     *
     * @Route("/module", name="content_api_module")
     *
     * @param Request $request Current request
     */
    public function moduleAction(Request $request)
    {
        $request = $this->init($request);

        return new ContentApiResponse(new ApiModule($request->query->get('id', 0)), 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/urls", name="content_api_urls")
     *
     * @param Request $request Current request
     */
    public function urlsAction(Request $request)
    {
        $request = $this->init($request);
        $file = $request->query->get('file', null);

        return new ContentApiResponse(UrlHelper::getUrls($file), 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/{reader}", name="content_api_reader")
     *
     * @param string  $reader  Reader (e.g. newsreader)
     * @param Request $request Current request
     */
    public function readerAction(string $reader, Request $request)
    {
        $request = $this->init($request);
        $readers = $this->getParameter('content_api_readers');
        if (!$readers[$reader]) {
            return new ContentApiResponse('Reader "'.$reader.'" not available'.$url, 404);
        }
        $url = $request->query->get('url', '/');
        $page = Page::findByUrl($url, false);
        $readerArticle = null;
        if ($page->hasReader($reader)) {
            $readerArticle = (new Reader($readers[$reader], $url))->toJson();
        }
        if (!$readerArticle) {
            return new ContentApiResponse('No reader found at URL '.$url, 404);
        }

        return new ContentApiResponse($readerArticle, 200, $this->headers);
    }

    /**
     * @return Response
     *
     * @Route("/", name="content_api_auto")
     *
     * @param Request $request Current request
     */
    public function indexAction(Request $request)
    {
        $request = $this->init($request);
        $readers = $this->getParameter('content_api_readers');
        $url = $request->query->get('url', '/');
        $exactMatch = false;
        try {
            $page = Page::findByUrl($url);
            $exactMatch = true;
        } catch (ContentApiNotFoundException $e) {
            try {
                $page = Page::findByUrl($url, false);
            } catch (ContentApiNotFoundException $e) {
                return new ContentApiResponse($e, 404);
            }
        }
        $response = [
            'page' => $page ? $page->toJson() : null,
        ];
        foreach ($readers as $type => $model) {
            if ($page->hasReader($type)) {
                $readerFound = true;
                $response[$type] = (new Reader($model, $url))->toJson();
            }
        }
        if (!$readerFound && !$exactMatch) {
            return new ContentApiResponse('No page and reader found at URL '.$url, 404);
        }

        return new ContentApiResponse($response, 200, $this->headers);
    }
}
