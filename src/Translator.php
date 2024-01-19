<?php

namespace Nabeghe\LightLocalization;

use ArrayAccess;

/**
 * Translator class.
 * @package Nabeghe\LightLocalization
 */
class Translator implements ArrayAccess
{
    public function offsetExists($offset)
    {
        return method_exists($this, $offset)
            || property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
        if (method_exists($this, $offset)) {
            return $this->$offset();
        }

        if (property_exists($this, $offset)) {
            return $this->$offset;
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $offset;
    }

    public function offsetUnset($offset)
    {
        if (property_exists($this, $offset)) {
            unset($this->$offset);
        }
    }
}