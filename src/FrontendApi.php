<?php

namespace DieSchittigs\ContaoContentApi;

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

    public function __construct($loader, $readers = null)
    {
        define('BYPASS_TOKEN_CHECK', true);
        define('TL_MODE', 'FE');
        define('BE_USER_LOGGED_IN', false);
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
        ManagerBundlePlugin::autoloadModules(dirname(__DIR__).'/system/modules');
        $kernel = new ContaoKernel('prod', false);
        $kernel->setRootDir(dirname(__DIR__).'/app');
        $request = Request::create('/_contao/initialize', 'GET');
        $request->attributes->set('_scope', 'frontend');
        $kernel->handle($request);
        if ($readers) {
            $this->readers = $readers;
        }
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
            case '/sitemap':
                $result = SitemapHelper::getSitemap(
                    $request->query->get('lang', null)
                );
            break;
            case '/page':
                $result = PageHelper::getPage(
                    $request->query->get('url', null)
                );
            break;
            case '/text':
                $result = TextHelper::get(
                    explode(',', $request->query->get('file', 'default')),
                    $request->query->get('lang', null)
                );
            break;
            case '/user':
                if ($this->user) {
                    $result = [
                        'id' => intVal($user->id),
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                    ];
                }
            break;
            case '/':
                $result = PageHelper::getPage(
                    $request->query->get('url', null)
                );
                if (!$result) {
                    foreach ($this->readers as $reader => $readerClass) {
                        $result = $this->handleReaders(
                            $reader,
                            $request->query->get('url', null)
                        );
                        if ($result) {
                            $result = [$reader => $result];
                            break;
                        }
                    }
                } else {
                    $result = ['page' => $result];
                }
                if (!$result) {
                    return new Response(
                        json_encode(['error' => Response::HTTP_NOT_FOUND]),
                        Response::HTTP_NOT_FOUND,
                        ['Content-Type', 'application/json']
                    );
                }
            break;
            default:
                $reader = substr($request->getPathInfo(), 1);
                $result = $this->handleReaders(
                    $reader,
                    $request->query->get('url', null)
                );
                if ($result) {
                    break;
                }
                return new Response(
                    json_encode(['error' => Response::HTTP_NOT_FOUND]),
                    Response::HTTP_NOT_FOUND,
                    ['Content-Type', 'application/json']
                );
        }
        $response = new Response(
            json_encode($result, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK),
            Response::HTTP_OK,
            ['Content-Type', 'application/json']
        );
        return $response;
    }

    private function handleReaders($reader, $url)
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
