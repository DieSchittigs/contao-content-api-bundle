<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\FilesModel;
use Contao\ImageSizeModel;
use Contao\ImageSizeItemModel;
use Contao\Image;

class FileHelper
{
    public static function file($uuid, $size = null)
    {
         $model = FilesModel::findByUuid($uuid);
         if(!$model) return null;
         $result = Helper::toObj($model);
         unset($result->pid);
         unset($result->uuid);
         $result->path = '/' . $result->path;
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
             try{
                 $result->resizedSrc = Image::create($uuid, $size)->executeResize()->getResizedPath();
             } catch (\Exception $e){
                $result->resizedSrc = null;
             }
         }
         return $result;
    }

    private static function children($uuid, $depth = 0){
        $models = FilesModel::findByPid($uuid);
        if(!$models) return [];
        $children = Helper::toObj($models);
        foreach($children as &$file){
            if($depth > 0){
                $file->children = static::children($file->uuid, $depth - 1);
            }
            unset($file->pid);
            unset($file->uuid);
        }
        return $children;
    }

    public static function get($path, $depth = 1)
    {
         $model = FilesModel::findByPath($path);
         if(!$model) return null;
         $result = Helper::toObj($model);
         if($depth > 0){
             $result->children = static::children($result->uuid, $depth - 1);
         }
         unset($result->pid);
         unset($result->uuid);
         return $result;
    }
}
