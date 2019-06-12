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

    /**
     * Set the value in the attached model.
     *
     * @param string $property key
     * @param mixed  $value    value
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            return $this;
        }
        $this->model->{$property} = $value;

        return $this;
    }
}
