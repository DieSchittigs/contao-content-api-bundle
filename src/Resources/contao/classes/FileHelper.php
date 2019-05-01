<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\FilesModel;
use Contao\Controller;

class FileHelper
{
    public static function file($uuid, $size = null)
    {
        $result = new \stdClass;
        $model = FilesModel::findByUuid($uuid);
        if(!$model) return null;
        if(!is_string($size)) $size = \serialize($size);
        $image = [
            'id' => $model->id,
            'uuid' => $model->uuid,
            'name' => $model->name,
            'singleSRC' => $model->path,
            'size' => $size,
            'filesModel' => $model
        ];
        Controller::addImageToTemplate($result, $image);
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

