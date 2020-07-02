<?php

namespace Core\DataBaseAdapter;

/**
 *
 * Class Mysql
 *
 * @package Core
 */
class Mysql implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * Mysql constructor.
     */
    public function __construct(string $host, string $name, string $user, string $pass)
    {
        $this->init($host, $name, $user, $pass);
    }

    /**
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     */
    public function init(string $host, string $name, string $user, string $pass)
    {
        $this->connection = new \PDO(
            "mysql:host={$host};dbname={$name};charset=utf8",
            $user,
            $pass
        );
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}