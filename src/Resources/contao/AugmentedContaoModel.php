<?php

namespace DieSchittigs\ContaoContentApiBundle;

/**
 * AugmentedContaoModel is a wrapper class to make handling Contao Models consistent.
 */
abstract class AugmentedContaoModel implements ContaoJsonSerializable
{
    public $model = null;

    public function toJson(): ContaoJson
    {
        if (!$this->model) {
            return new ContaoJson(null);
        }
        $reflect = new \ReflectionObject($this);
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            if ($prop->class == 'DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel') continue;
            $this->model->{$prop->name} = $this->{$prop->name};
        }

        return new ContaoJson($this->model);
    }

    /**
     * Get the value from the attached model.
     *
     * @param string $property key
     */
    public function __get($property)
    {
        return $this->model->{$property} ?? null;
    }
}
