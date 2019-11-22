<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\FilesModel;
use Contao\Controller;

/**
 * File augments FilesModel for the API.
 */
class File extends AugmentedContaoModel
{
    private static $fileObj = [
        'id',
        'uuid',
        'name',
        'extension',
        'singleSRC',
        'meta',
        'size',
        'filesModel',
    ];

    /**
     * constructor.
     *
     * @param string $uuid uuid of the FilesModel
     * @param mixed  $size Object or serialized string representing the (image) size
     */
    public function __construct($uuid, $size = null)
    {
        $this->model = FilesModel::findByUuid($uuid);
        if (!$this->model || empty($this->model)) {
            return $this->model = null;
        }
        if (!is_string($size)) {
            $size = \serialize($size);
        }
        $fileObj = [];
        foreach ($this->model as $key => $value) {
            if (in_array($key, self::$fileObj)) {
                $fileObj[$key] = $value;
            }
        }
        $fileObj['singleSRC'] = $this->path;
        $this->mime = \mime_content_type(TL_ROOT.'/'.$this->path) ?? null;
        if ($this->type == 'file' && strpos($this->mime, 'image') !== false) {
            $fileObj['size'] = $size;
            $image = new \stdClass();
            Controller::addImageToTemplate($image, $fileObj);
            if ($image) {
                $this->image = $image;
            }
        }
    }

    /**
     * Recursively load file (directory) children.
     *
     * @param string $uuid  uuid of the FilesModel
     * @param int    $depth How deep do you want to fetch children?
     */
    private static function children($uuid, $depth = 0)
    {
        $models = FilesModel::findByPid($uuid);
        if (!$models) {
            return [];
        }
        $children = [];
        foreach ($models as $_file) {
            $file = new self($_file->uuid);
            if ($depth > 0) {
                $file->children = self::children($file->uuid, $depth - 1);
            }
            $children[] = $file;
        }

        return $children;
    }

    /**
     * Recursively load file by path.
     *
     * @param string $path  Path of the FilesModel
     * @param int    $depth How deep do you want to fetch children?
     */
    public static function get($path, $depth = 1)
    {
        $model = FilesModel::findByPath($path);
        if (!$model) {
            return null;
        }
        $file = new self($model->uuid);
        if ($depth > 0) {
            $file->children = self::children($file->uuid, $depth - 1);
        }

        return $file;
    }

    public function toJson(): ContaoJson
    {
        if (!$this->model) {
            return parent::toJson();
        }
        $file = $this->model->row();
        unset($file['uuid']);
        unset($file['pid']);

        return new ContaoJson($file);
    }
}
