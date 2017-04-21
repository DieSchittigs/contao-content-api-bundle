<?php
namespace DieSchittigs\ContaoContentApi;

use Contao\System;
use Contao\Frontend;
use Contao\Input;

class TextHelper
{
    public static function get($langFiles, $lang=null)
    {
        if (!$lang) $lang = Helper::defaultLang();
        if(!is_array($langFiles)) $langfiles = [$langFiles];
        foreach($langFiles as $langFile){
            System::loadLanguageFile($langFile, $lang);
        }
        return $GLOBALS['TL_LANG'];
    }
}
