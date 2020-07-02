<?php

namespace Core\Exception;

use Throwable;

/**
 * Class RequestMethodNotFoundException
 *
 * @package Core\Exception
 */
class RequestMethodNotFoundException extends \Exception
{
    /**
     * RequestMethodNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|NULL $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = NULL)
    {
        parent::__construct($message ?? 'Request method not found exception', $code, $previous);
    }
}
