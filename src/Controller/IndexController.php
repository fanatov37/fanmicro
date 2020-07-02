<?php

namespace App\Controller;

use Core\Controller\AbstractController;

/**
 * Class IndexController
 *
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     *
     */
    public function indexAction()
    {
        $this->sendJson(['Hello world']);
    }
}