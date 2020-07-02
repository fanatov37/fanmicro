<?php

namespace Core\Container;

/**
 * Trait ContainerAwareTrait
 *
 * @package Core\Container
 */
trait ContainerAwareTrait
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @return Container
     *
     * @throws \LogicException
     */
    public function getContainer() : Container
    {
        return $this->container;
    }

    /**
     * @param Container $container
     *
     * @return mixed|void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
