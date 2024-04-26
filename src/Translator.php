<?php namespace Nabeghe\LightLocalization;

/**
 * Translator class.
 * @package Nabeghe\LightLocalization
 */
#[\AllowDynamicProperties]
class Translator implements \ArrayAccess
{
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return method_exists($this, $offset)
            || property_exists($this, $offset);
    }

    #[\ReturnTypeWillChange]
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

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->$offset = $offset;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        if (property_exists($this, $offset)) {
            unset($this->$offset);
        }
    }
}