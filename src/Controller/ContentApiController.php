<?php

namespace DieSchittigs\ContaoContentApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use DieSchittigs\ContaoContentApiBundle\FrontendApi;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", defaults={"_scope" = "frontend", "_token_check" = false})
 */
class ContentApiController extends Controller
{

    public function __construct(){
        $this->frontendApi = new FrontendApi();
    }

    private function handle(Request $request){
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


}
