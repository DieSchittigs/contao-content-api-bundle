<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ManagerBundle\ContaoManager\Plugin as ManagerBundlePlugin;
use Contao\ManagerBundle\HttpKernel\ContaoCache;
use Contao\ManagerBundle\HttpKernel\ContaoKernel;
use Contao\Environment;
use Contao\System;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendApi
{
    private $readers = [
        'news' => 'NewsModel'
    ];
    private $user;

    public function __construct($readers = null)
    {
        if($readers) $this->readers = $readers;
        $apiUser = new ApiUser;
        $this->user = $apiUser->getUser();
    }

    public function addReader($reader, $class)
    {
        $this->readers[$reader] = $class;
    }

    private function setLang(Request $request){
        $globalLang = $request->query->get('lang', Helper::defaultLang());
        $GLOBALS['TL_LANGUAGE'] = $globalLang;
        $_SESSION['TL_LANGUAGE'] = $globalLang;
        System::loadLanguageFile('default', $globalLang);
    }

    private function overrideRequestUri(Request $request){
        $_SERVER["REQUEST_URI"] = $request->query->get('url', $_SERVER["REQUEST_URI"]);
    }

    public function handle(Request $request)
    {
        $this->overrideRequestUri($request);
        $this->setLang($request);

        $result = null;
        switch ($request->getPathInfo()) {
            case '/api/sitemap':
                $result = SitemapHelper::getSitemap(
                    $request->query->get('lang', null)
                );
            break;
            case '/api/page':
                $result = PageHelper::getPage(
                    $request->query->get('url', null)
                );
            break;
            case '/api/text':
                $result = TextHelper::get(
                    explode(',', $request->query->get('file', 'default')),
                    $request->query->get('lang', null)
                );
            break;
            case '/api/file':
                $result = FileHelper::get(
                    $request->query->get('path', null),
                    $request->query->get('depth', 0)
                );
            break;
            case '/api/user':
                if ($this->user) {
                    $result = [
                        'id' => intVal($user->id),
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                    ];
                }
            break;
            case '/api/module':
                $result = ModuleHelper::get(
                    $request->query->get('id', null)
                );
            break;
            case '/api/':
                $result = new \stdClass;
                $result->page = PageHelper::getPage(
                    $request->query->get('url', null),
                    true
                );
                foreach ($this->readers as $reader => $readerClass) {
                    $readerResult = $this->handleReader(
                        $reader,
                        $request->query->get('url', null)
                    );
                    if ($readerResult) {
                        $result->{$reader} = $readerResult;
                    }
                }
            break;
            default:
                $reader = substr($request->getPathInfo(), 5);
                $result = $this->handleReader(
                    $reader,
                    $request->query->get('url', null)
                );
        }
        return $result;
    }

    private function handleReader($reader, $url)
    {
        if (array_key_exists($reader, $this->readers)) {
            return ReaderHelper::handle(
                $this->readers[$reader],
                $url
            );
        }
        return null;
    }
}
