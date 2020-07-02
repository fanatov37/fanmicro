<?php

namespace Core\Controller;

/**
 * Class ErrorController
 *
 * @package Core\Controller
 */
class ErrorController extends AbstractController
{
    /**
     * @param int $number
     * @param string $message
     * @param string $file
     * @param int $line
     */
    public function errorHandler(int $number, string $message, string $file, int $line)
    {
        /** @todo now it's for all will be 404 */
        switch ($number) {
            case E_ERROR:
            case E_WARNING:
            case E_NOTICE:
            default:
                $this->_404();

                $this->sendJson([
                    'success' => false,
                    'msg' => "Error [{$number}] | $message"
                ]) ;
                break;
        }
    }

    /**
     * Redirect to page not found
     */
    protected function _404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header( 'HTTP/1.1 404 Not Found' );
        header( 'Status: 404 Not Found' );
        header( 'Location:' . $host . '404' );
    }
}