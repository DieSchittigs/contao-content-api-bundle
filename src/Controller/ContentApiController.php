<?php

namespace DieSchittigs\ContaoContentApiBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use DieSchittigs\ContaoContentApiBundle\FrontendApi;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", defaults={"_scope" = "frontend", "_token_check" = false})
 */
class ContentApiController extends Controller
{

    private function handle(Request $request){
        $readers = $this->getParameter('content_api_readers');
        $this->frontendApi = new FrontendApi($readers);
        $this->container->get('contao.framework')->initialize();
        return $this->json($this->frontendApi->handle($request));
    }

    /**
     * @return Response
     *
     * @Route("/sitemap", name="content_api_sitemap")
     */
    public function sitemapAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/page", name="content_api_page")
     */
    public function pageAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/user", name="content_api_user")
     */
    public function userAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/file", name="content_api_file")
     */
    public function fileAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/module", name="content_api_module")
     */
    public function moduleAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/", name="content_api_auto")
     */
    public function indexAction(Request $request)
    {
        return $this->handle($request);
    }

    /**
     * @return Response
     *
     * @Route("/{reader}", name="content_api_reader")
     */
    public function readerAction(Request $request)
    {
        return $this->handle($request);
    }


}
