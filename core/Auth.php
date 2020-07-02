<?php

namespace Core;

use App\Repository\UserRepository;

/**
 *
 * Class AuthService
 *
 * @package Core
 */
class Auth
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var int
     */
    private $id = null;

    /**
     * @var string
     */
    private $email = null;

    /**
     * @var string
     */
    private $token = null;

    /**
     * Auth constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $token
     */
    public function setAuth(string $token)
    {
        $result = $this->userRepository->getByToken($token);

        if ($result) {
            $this->id = (int)$result['id'];
            $this->email = (int)$result['email'];
            $this->token = $token;
        }
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getEmail() : ?int
    {
        return $this->email;
    }
}
