<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Model\Collection;
use Contao\Model;
use Contao\Controller;
use Contao\StringUtil;

/**
 * ContaoJson tries to pack "everything Contao" into a JSON-serializable package.
 *
 * It works with:
 *  - Contao Collections
 *  - Contao Models
 *  - Arrays (of Models or anything else)
 *  - Objects
 *  - Strings and numbers
 * The main features are
 *  - File objects (e.g. singleSRC) are resolved automatically
 *  - Serialized arrays are resolved automatically
 *  - HTML will be unescaped automatically
 *  - Contao Insert-Tags are resolved automatically
 * ContaoJson will recursively call itself until all fields are resolved.
 */
class ContaoJson implements \JsonSerializable
{
    public $data = null;
    private $allowedFields;

    /**
     * constructor.
     *
     * @param mixed $data          any data you want resolved and serialized
     * @param array $allowedFields an array of whitelisted keys (non-matching values will be purged)
     */
    public function __construct($data, array $allowedFields = null)
    {
        $this->allowedFields = $allowedFields;
        $doHandle = true;
        if (isset($GLOBALS['TL_HOOKS']['apiContaoJson']) && is_array($GLOBALS['TL_HOOKS']['apiContaoJson'])) {
            foreach ($GLOBALS['TL_HOOKS']['apiContaoJson'] as $callback) {
                $doHandle = $callback[0]::{$callback[1]}($this, $data);
            }
        }
        if (!$doHandle) {
            return;
        }
        if ($data instanceof ContaoJsonSerializable) {
            $data = $data->toJson();
        }
        if ($data instanceof ContaoJson) {
            return $this->data = $data;
        }
        if ($data instanceof Collection) {
            $data = $this->handleCollection($data);
        }
        if ($data instanceof Model) {
            $data = $data->row();
        }
        if (is_array($data)) {
            if ($this->isAssoc($data)) {
                $data = (object) $data;
            } else {
                $data = $this->handleArray($data);
            }
        }
        if (is_object($data)) {
            $data = $this->handleObject($data);
        }
        if (is_numeric($data)) {
            $data = $this->handleNumber($data);
        }
        if (is_string($data)) {
            $data = $this->handleString($data);
        }
        $this->data = $data;
    }

    private function handleCollection(Collection $collection)
    {
        $data = [];
        foreach ($collection->getModels() as $model) {
            $data[] = $model->row();
        }

        return $data;
    }

    private function handleArray(array $array)
    {
        $data = [];
        foreach ($array as $item) {
            $data[] = new ContaoJson($item, $this->allowedFields);
        }

        return $data;
    }

    private function handleObject(object $object)
    {
        $data = new \stdClass();
        foreach ($object as $key => $value) {
            if ($this->allowedFields && !in_array($key, $this->allowedFields)) {
                unset($object->{$key});
                continue;
            }
            if ((strpos($key, 'SRC') !== false || $key == 'pageImage') && $value) {
                $src = $this->unserialize($value);
                if (is_array($src)) {
                    $files = [];
                    foreach ($src as $_key => $_val) {
                        $files[] = (new File($_val, $object->size ?? null))->toJson();
                    }
                    $data->{$key} = $files;
                } else {
                    $data->{$key} = (new File($src, $object->size ?? null))->toJson();
                }
            } else if ($key == 'author' && is_numeric($value)) {
                $data->{$key} = (new Author($value))->toJson();
            } else {
                $data->{$key} = new self($value);
            }
        }

        return $data;
    }

    private function handleNumber($number)
    {
        return $number ?? 0;
    }

    private function handleString(string $string)
    {
        // Fix binary or otherwise "broken" strings
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        $unserialized = $this->unserialize($string);
        if (!is_string($unserialized)) {
            return new ContaoJson($unserialized);
        }
        $string = Controller::replaceInsertTags($string);
        $string = trim($string);
        $string = preg_replace('/[[:blank:]]+/', ' ', $string);

        return StringUtil::decodeEntities($string, ENT_HTML5, 'UTF-8');
    }

    private function isAssoc(array $arr)
    {
        if (array() === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function unserialize(string $string)
    {
        $unserialized = @unserialize($string);
        if ($unserialized !== false) {
            if ($this->isAssoc($unserialized)) {
                return (object) $unserialized;
            } else {
                return $unserialized;
            }
        }

        return $string;
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
