<?php

namespace GuilhermeHideki\Core\Address;

class Cep
{
    /**
     * @var string
     */
    private $value;

    /**
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function formatted($value)
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
