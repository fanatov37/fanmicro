<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Core\Controller\AbstractController;

/**
 * Class UserController
 *
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * IndexController constructor.
     *
     **
     * IndexController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function createAction()
    {
        $email = $this->getStringParam('email');
        $password = $this->getStringParam('password');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("E-mail {$email} is wrong");
        }

        $this->userRepository->create($email, $password);
        $this->sendJson(['success' => true]);
    }

    /**
     * @throws \Exception
     */
    public function loginAction()
    {
        $email = $this->getStringParam('email');
        $password = $this->getStringParam('password');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("E-mail {$email} is wrong");
        }

        $token = $this->userRepository->getTokenByEmailAndPass($email, $password);

        $this->sendJson([
            'success' => true,
            'token' => $token
        ]);
    }
}