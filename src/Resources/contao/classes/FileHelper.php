<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\FilesModel;
use Contao\ImageSizeModel;
use Contao\ImageSizeItemModel;

class FileHelper
{
    public static function file($uuid, $size = null)
    {
         $model = FilesModel::findOneBy('uuid', $uuid);
         if(!$model) return null;
         $result = Helper::toObj($model);
         unset($result->pid);
         unset($result->uuid);
         $result->path = '/' + $result->path;
         if($size && count($size) == 3){
             if(is_numeric($size[2])){
                 $result->size = Helper::toObj(ImageSizeModel::findOneById($size[2]));
                 if($result->size){
                     $result->size->subSizes = Helper::toObj(ImageSizeItemModel::findVisibleByPid($result->size->id));
                 }
             } else {
                 $result->size = [
                     'width' => $size[0],
                     'height' => $size[1],
                     'resizeMode' => $size[2]
                 ];
             }
         }
         return $result;
    }
}
