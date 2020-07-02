<?php

namespace Core;

use Core\Container\Container;
use Core\Controller\AbstractController;
use Core\Exception\ActionNotFoundException;

/**
 * Class RouteService
 *
 * @package Core
 */
class Route
{
    CONST DEFAULT_CONTROLLER = 'Index';

    CONST DEFAULT_ACTION = 'index';

    CONST DEFAULT_CONTROLLER_PREFIX = 'Controller';

    CONST DEFAULT_ACTION_PREFIX = 'Action';

    CONST DEFAULT_CONTROLLER_NAMESPACE = 'App\Controller\\';

    /**
     * @var Container
     */
    private $container;

    /**
     * @var object
     */
    private $controller;

    /**
     * Route constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * (non-PHPDoc)
     */
    public function request()
    {
        try {
            $controllerName = self::DEFAULT_CONTROLLER;
            $actionName = self::DEFAULT_ACTION;
            $parseUrl = parse_url($_SERVER['REQUEST_URI']);
            $routes = explode ('/', $parseUrl['path']);

            if (count($routes) > 3) {
                throw new \Exception('Route is wrong.');
            }

            if (!empty($routes[1])) {
                $controllerName = ucfirst($this->impodeRoute($routes[1]));
            }
            if (!empty( $routes[2])) {
                $actionName = lcfirst($this->impodeRoute($routes[2]));
            }

            $controllerName = self::DEFAULT_CONTROLLER_NAMESPACE . $controllerName . self::DEFAULT_CONTROLLER_PREFIX ;
            $actionName = $actionName . self::DEFAULT_ACTION_PREFIX;

            /** @var AbstractController $controller */
            $this->controller = $this->container->get($controllerName);
            if ($this->controller instanceof AbstractController) {
                $this->controller->setContainer($this->container);
                $this->controller->preDispatch();
            }

            if (!method_exists($this->controller, $actionName)) {
                throw new ActionNotFoundException();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                header('Content-Type: text/html; charset=UTF-8');
                header('Access-Control-Allow-Headers: content-type, authorization');
                header('Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin: *');
                return;
            }

            /** @todo now only post  */
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Only POST available now. Sorry');
            }

            $this->controller->$actionName();

        } catch (\Throwable $exception) {
            trigger_error($exception->getMessage(), E_USER_ERROR);
        }
    }

    /**
     *
     * @param $routes string
     *
     * @return string
     */
    private function impodeRoute($routes) : string
    {
        $name = '';
        $routesImplode = explode ('-', $routes);

        foreach ($routesImplode as $item) {
            $name .= $item;
        }

        return $name;
    }
}
