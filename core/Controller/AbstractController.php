<?php

namespace Core\Controller;

use Core\Auth;
use Core\Container\ContainerAwareInterface;
use Core\Container\ContainerAwareTrait;
use Core\Exception\NeedAuthException;

/**
 * Class AbstractController
 *
 * @package Core\Controller
 */
abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait,
        ParamTrait;

    /**
     * @param array $data
     */
    protected function sendJson(array $data=[])
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        echo json_encode($data);
    }

    /**
     * if you wanna that your Action has control
     * under user, you must return true
     *
     *
     * @return bool
     */
    protected function isPreDispatch()
    {
        return false;
    }

    /**
     * @throws NeedAuthException
     * @throws \Core\Container\Exception\ContainerException
     * @throws \Core\Container\Exception\ServiceNotFoundException
     * @throws \ReflectionException
     */
    public function preDispatch()
    {
        if ($this->isPreDispatch()) {

            /** @var Auth $auth */
            $auth = $this->getContainer()->get(Auth::class);
            $token = $this->getStringParam('token');

            if (!$token) {
                throw new NeedAuthException('Token is empty');
            }

            $auth->setAuth($token);

            if (!$auth->getId()) {
                throw new NeedAuthException('Need user auth');
            }
        }
    }
}
