<?php

namespace Core\Container;

/**
 * Interface ContainerAwareInterface
 *
 * @package Core\Container
 */
interface ContainerAwareInterface
{
    /**
     * @param Container $container
     *
     * @return mixed
     */
    public function setContainer(Container $container);

    /**
     * @return Container
     */
    public function getContainer() : Container;
}
