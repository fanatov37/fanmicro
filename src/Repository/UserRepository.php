<?php

namespace App\Repository;

use Core\DataBaseAdapter\AdapterInterface;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository
{
    /**
     * @var AdapterInterface
     */
    private $dbAdapter;

    /**
     * UserRepository constructor.
     *
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @throws \Exception
     */
    public function create (string $email, string $password)
    {
        if ($this->getByEmail($email)) {
            throw new \Exception('Something gonna wrong');
        }

        $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
        $stmt= $this->dbAdapter->getConnection()->prepare($sql);

        /** @todo simple md5. need use mbcrypt */
        $result = $stmt->execute([$email, md5($password)]);

        if (!$result) {
            throw new \Exception('Error for create user');
        }
    }

    /**
     * @param int $id
     */
    public function remove (int $id)
    {
        $sql = "DELETE from user where id = ?";
        $stmt= $this->dbAdapter->getConnection()->prepare($sql);
        $stmt->execute([$id]);
    }

    /**
     * @param string $email
     *
     * @return array
     */
    public function getByEmail(string $email) : array
    {
        $sql = "SELECT id, email, password FROM user where email = ?";
        $stmt= $this->dbAdapter->getConnection()->prepare($sql);
        $stmt->execute([$email]);

        $result = $stmt->fetchAll();

        return $result ? $result[0] : [];
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return string|null
     */
    public function getTokenByEmailAndPass(string $email, string $password) : ?string
    {
        $sql = "SELECT MD5(concat(id, email, password)) FROM user where email=? and password=?";
        $stmt= $this->dbAdapter->getConnection()->prepare($sql);
        $stmt->execute([$email, md5($password)]);

        $result = $stmt->fetchColumn();

        return $result;
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function getByToken(string $token) : array
    {
        $sql = "
            SELECT id, email FROM (
            SELECT id, email, MD5(concat(id, email, password)) AS token FROM user
            ) res WHERE token=?
        ";

        $stmt= $this->dbAdapter->getConnection()->prepare($sql);
        $stmt->execute([$token]);

        $result = $stmt->fetchAll();

        return $result ? $result[0] : [];
    }
}