<?php

namespace Core\Container\Exception;

use Interop\Container\Exception\NotFoundException as InteropNotFoundException;

/**
 * Class ServiceNotFoundException
 *
 * @package Core\Container\Exception
 */
class ServiceNotFoundException extends \Exception implements InteropNotFoundException {}
