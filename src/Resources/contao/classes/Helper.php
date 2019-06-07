<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Model\Collection;
use Contao\Model;
use Contao\Controller;
use Contao\Module;
use Contao\Config;
use Contao\PageModel;

class Helper
{
    public static function toObj($instance, $fields = null, $debug=false)
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
        $imageSize = null;
        $images = [];
        foreach ($obj as $key => $val) {
            if ($fields && !in_array($key, $fields)) {
                unset($obj->$key);
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
            if($key == 'size'){
                $imageSize = $val;
            }
            if (strpos($key, 'SRC') !== false && $val) {
                $images[$key] = $val;
            }
            $obj->$key = $val;
        }
        
        foreach($images as $key => $image){
            if (is_array($image)) {
                $val = [];
                foreach ($image as $_key => $_val) {
                    $val[] = FileHelper::file($_val, $imageSize, $debug);
                }
                $obj->$key = $val;
            } else {
                $obj->$key = FileHelper::file($image, $imageSize, $debug);
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
        $html = str_replace('src="assets', 'src="/assets', $html);
        $html = str_replace('href="assets', 'href="/assets', $html);
        $html = str_replace('srcset="assets', 'href="/assets', $html);
        return $html;
    }

    public static function replaceURL($url){
        $apiScript = substr($_SERVER['SCRIPT_NAME'], 1);
        return str_replace($apiScript, '', $url);
    }

    public static function urlToLanguage($url)
    {
        if (Config::get('addLanguageToUrl')){
            $parts = explode('/', $url);
            if(count($parts) >=  3 && strlen($parts[1]) == 2) return $parts[1];
        }
        return static::defaultLang();
    }

    public static function urlToAlias($url)
    {
        $suffix = Config::get('urlSuffix');
        if ($suffix && strpos($url, $suffix) === false) {
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
        return substr($url, 0, ((strlen($suffix)>0) ? -strlen($suffix) : strlen($url)));
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
