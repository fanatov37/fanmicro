<?php

namespace Core\DataBaseAdapter;

/**
 * Interface AdapterInterface
 *
 * @package Psr\Container
 */
interface AdapterInterface
{
    /**
     * init PDO
     */
    public function init(string $host, string $name, string $user, string $pass);

    /**
     * @return \PDO
     */
    public function getConnection() : \PDO;
}
