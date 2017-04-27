<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\Model\Collection;
use Contao\Model;
use Contao\Controller;
use Contao\Module;
use Contao\Config;
use Contao\PageModel;

class Helper
{
    public static function toObj($instance, $fields = null)
    {
        if (!$instance) {
            return null;
        }
        if ($instance instanceof Collection) {
            $arr = [];
            foreach ($instance->getModels() as $row) {
                $arr[] = static::toObj($row, $fields);
            }
            return $arr;
        } elseif ($instance instanceof Model) {
            $obj = $instance->row();
        } else {
            $obj = (object) $instance;
        }
        foreach ($obj as $key => &$val) {
            $originalVal = $val;
            if ($fields && !in_array($key, $fields)) {
                unset($obj[$key]);
                continue;
            }
            $unserializedVal = @unserialize($val);
            if ($unserializedVal !== false) {
                $val = $unserializedVal;
            }

            if ($key == 'html' || $key == 'text' || $key == 'teaser') {
                $val = static::replaceHTML($val);
            }
            if ($val == '') {
                $val = null;
            }
            if (strpos($key, 'SRC') !== false && $val) {
                if (is_array($val)) {
                    $__val = [];
                    foreach ($val as $_key => $_val) {
                        $__val[] = FileHelper::file($_val);
                    }
                    $val = $__val;
                } else {
                    $val = FileHelper::file($val);
                }
            }
        }
        return (object) $obj;
    }
    public static function replaceHTML($html)
    {
        $apiScript = substr($_SERVER['SCRIPT_NAME'], 1);
        $html = Controller::replaceInsertTags($html);
        $html = trim($html);
        $html = preg_replace("/[[:blank:]]+/", " ", $html);
        $html = str_replace('"'.$apiScript, '"', $html);
        $html = str_replace('src="files', 'src="/files', $html);
        $html = str_replace('href="files', 'href="/files', $html);
        return $html;
    }

    public static function replaceURL($url){
        $apiScript = substr($_SERVER['SCRIPT_NAME'], 1);
        return str_replace($apiScript, '', $url);
    }

    public static function urlToAlias($url)
    {
        $suffix = Config::get('urlSuffix');
        if (strpos($url, $suffix) === false) {
            return null;
        }
        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }
        if (Config::get('addLanguageToUrl')) {
            $matches = array();
            if (preg_match('@^([a-z]{2}(-[A-Z]{2})?)/(.*)$@', $url, $matches)) {
                if ($matches[3] == '') {
                    return null;
                }
                $url = $matches[3];
            } else {
                return null;
            }
        }
        return substr($url, 0, -strlen($suffix));
    }

    public static function defaultLang(){
        $rootPages = PageModel::findPublishedRootPages();
        foreach($rootPages as $rootPage){
            $rootPage->loadDetails();
            if($rootPage->fallback){
                return $rootPage->language;
            }
        }
        return 'en';
    }
}
