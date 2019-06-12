<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\System;

class TextHelper
{
    public static function get($langFiles, $lang = null)
    {
        if (!is_array($langFiles)) {
            $langfiles = [$langFiles];
        }
        $GLOBALS['TL_LANG'] = [];
        foreach ($langFiles as $langFile) {
            System::loadLanguageFile($langFile, $lang);
        }

        return (object) $GLOBALS['TL_LANG'];
    }
}
