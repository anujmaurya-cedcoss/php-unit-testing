<?php
namespace Index\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo "HI";
    }

    /**
     * @param int $a
     * @param int $b
     */
    public function addAction(int $a, int $b): int
    {
        return $a + $b;
    }
}
