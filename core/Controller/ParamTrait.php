<?php

namespace Core\Controller;

/**
 * Trait ParamTrait
 *
 * @package Core\Controller
 */
trait ParamTrait
{
    /**
     * @param string $paramName
     * @param null $default
     *
     * @return string|null
     */
    public function getStringParam(string $paramName, $default = null) :?string
    {
        $value = (string)filter_input(INPUT_POST, $paramName, FILTER_SANITIZE_STRING);

        return $value ?? $default;
    }

    /**
     * @param $paramName
     * @param null $default
     *
     * @return float|null
     */
    public function getFloatParam(string $paramName, $default = null) :?float
    {
        $value = (float)filter_input(INPUT_POST, $paramName, FILTER_VALIDATE_FLOAT);

        return $value ?? $default;
    }

    /**
     * @param string $paramName
     * @param null $default
     *
     * @return bool|null
     */
    public function getBoolParam(string $paramName, $default = null) :?bool
    {
        $value = (bool)filter_input(INPUT_POST, $paramName, FILTER_VALIDATE_BOOLEAN);

        return $value ?? $default;
    }
}
