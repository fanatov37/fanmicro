<?php

namespace App\Service\Parse;

/**
 * Class ParseService
 *
 * @package App\Service\Parse
 */
interface ParseTypeInterface
{
    /**
     * @param string $filePath
     *
     * @return mixed
     */
    public function parseFile(string $filePath) : array;
}
