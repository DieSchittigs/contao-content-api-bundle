<?php
namespace DieSchittigs\ContaoContentApi;

use Contao\System;
use Contao\Frontend;
use Contao\Input;

class TextHelper
{
    public static function get($langFile, $lang=null)
    {
        if (!$lang) {
            Frontend::getPageIdFromUrl();
            $lang = Input::get('language');
        }
        $result = System::loadLanguageFile($langFile, $lang);
        if ($result) {
            return (object) $result;
        }
        return null;
    }
}
