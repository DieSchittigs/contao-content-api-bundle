<?php

namespace DieSchittigs\ContaoContentApiBundle;

/**
 * ContaoJsonSerializable is an interface which tags objects that are supposed to
 * be serialized into an ContaoJson instance.
 */
interface ContaoJsonSerializable
{
    public function toJson(): ContaoJson;
}
