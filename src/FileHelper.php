<?php

namespace DieSchittigs\ContaoContentApi;

use Contao\FilesModel;

class FileHelper
{
    public static function file($uuid)
    {
         $model = FilesModel::findOneBy('uuid', $uuid);
         if(!$model) return null;
         $result = Helper::toObj($model);
         unset($result->pid);
         unset($result->uuid);
         return $result;
    }
}
