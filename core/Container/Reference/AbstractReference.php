<?php

namespace Core\Container\Reference;

/**
 * Class AbstractReference
 *
 * @package Core\Container\Reference
 */
abstract class AbstractReference
{
    /**
     * @var string
     */
    private $name;

    /**
     * AbstractReference constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
