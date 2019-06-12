<?php

namespace DieSchittigs\ContaoContentApiBundle;

class UrlHelper
{
    public static function getUrls($file = null)
    {
        $urls = new \stdClass();
        if ($file) {
            $urls = self::parseSitemapXml("$file.xml");
        } else {
            foreach (scandir(TL_ROOT.'/web/share/') as $file) {
                if (substr($file, -4) == '.xml') {
                    $urls = (object) array_merge(
                        (array) $urls,
                        (array) self::parseSitemapXml($file)
                    );
                }
            }
        }

        return $urls;
    }

    private static function parseSitemapXml($file)
    {
        $urls = new \stdClass();
        $filePath = TL_ROOT."/web/share/$file";
        $xml = simplexml_load_file($filePath);
        $sitemap = json_decode(json_encode($xml));
        foreach ($sitemap->url as $item) {
            $parsedUrl = \parse_url($item->loc);
            $urls->{$parsedUrl['path']} = $parsedUrl;
        }

        return $urls;
    }
}
