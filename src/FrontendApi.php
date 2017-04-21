<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\ManagerBundle\ContaoManager\Plugin as ManagerBundlePlugin;
use Contao\ManagerBundle\HttpKernel\ContaoCache;
use Contao\ManagerBundle\HttpKernel\ContaoKernel;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendApi
{
    private $readers = [
        'news' => 'NewsModel'
    ];

    public function __construct($loader, $readers = null)
    {
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
    }

    public function addReader($reader, $class)
    {
        $this->readers[$reader] = $class;
    }

    public function handle(Request $request)
    {
        if ($request->query->get('url')) {
            $_SERVER["REQUEST_URI"] = $request->query->get('url');
        }
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
                $apiUser = new ApiUser;
                if ($user = $apiUser->getUser()) {
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
