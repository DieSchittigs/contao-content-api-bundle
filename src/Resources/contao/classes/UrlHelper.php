<?php
namespace DieSchittigs\ContaoContentApiBundle;

use Contao\System;
use Contao\Frontend;
use Contao\Input;

class UrlHelper
{
    public static function getUrls($file = null)
    {
        if($file){
            $urls = self::parseSitemapXml("$file.xml");
        } else {
            foreach(scandir(TL_ROOT . "/web/share/") as $file){
                if(substr($file, -4) == '.xml'){
                    $urls[] = self::parseSitemapXml($file);
                }
            }
        }
        return $urls;
    }

    private static function parseSitemapXml($file){
        $urls = [];
        $filePath = TL_ROOT . "/web/share/$file";
        $xml = simplexml_load_file($filePath);
        $sitemap = json_decode(json_encode($xml));
        foreach($sitemap->url as $item){
            $parsedUrl = \parse_url($item->loc);
            $urls[$parsedUrl['path']] = $parsedUrl;
        }
        return $urls;
    }
}
