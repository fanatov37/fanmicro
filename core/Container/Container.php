<?php

namespace Core\Container;

use Core\Container\Exception\ContainerException;
use Core\Container\Exception\ServiceNotFoundException;
use Core\Container\Reference\ServiceReference;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package Core\Container
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $services;

    /**
     * @var array
     */
    private $serviceStore;

    /**
     * Container constructor.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->services = $services;
        $this->serviceStore = [];
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws \ReflectionException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException("Service not found: {$id}");
        }

        if (!isset($this->serviceStore[$id])) {
            $this->serviceStore[$id] = $this->createService($id);
        }

        return $this->serviceStore[$id];
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function has($id) : bool
    {
        return isset($this->services[$id]);
    }

    /**
     * @param string $name
     *
     * @return object
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws \ReflectionException
     */
    private function createService(string $name) : object
    {
        $entry = &$this->services[$name];

        if (!is_array($entry) || !isset($entry['class'])) {
            throw new ContainerException("{$name} service entry must be an array containing a 'class' key");
        } elseif (!class_exists($entry['class'])) {
            throw new ContainerException("{$name} service class does not exist: {$entry['class']} ");
        } elseif (isset($entry['lock'])) {
            throw new ContainerException("{$name} contains circular reference");
        }

        $entry['lock'] = true;
        $arguments = isset($entry['arguments']) ? $this->resolveArguments($entry['arguments']) : [];
        $reflector = new \ReflectionClass($entry['class']);
        $service = $reflector->newInstanceArgs($arguments);

        return $service;
    }

    /**
     * @param array $argumentDefinitions
     *
     * @return array
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws \ReflectionException
     */
    private function resolveArguments(array $argumentDefinitions)
    {
        $arguments = [];

        foreach ($argumentDefinitions as $argumentDefinition) {
            if ($argumentDefinition instanceof ServiceReference) {
                $argumentServiceName = $argumentDefinition->getName();
                $arguments[] = $this->get($argumentServiceName);
            } else {
                $arguments[] = $argumentDefinition;
            }
        }
        return $arguments;
    }
}