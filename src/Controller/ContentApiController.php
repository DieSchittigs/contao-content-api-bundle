<?php

namespace DieSchittigs\ContaoContentApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use DieSchittigs\ContaoContentApiBundle\SitemapHelper;

/**
 * @Route("/api", defaults={"_scope" = "frontend", "_token_check" = false})
 */
class ContentApiController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/sitemap", name="content_api_sitemap")
     */
    public function sitemapAction($request)
    {
        $this->container->get('contao.framework')->initialize();

        $result = SitemapHelper::getSitemap(
            $request->query->get('lang', null)
        );

        $response = new Response(
            json_encode($result, JSON_NUMERIC_CHECK),
            Response::HTTP_OK,
            ['Content-Type', 'application/json']
        );
        return $response;
    }
}
