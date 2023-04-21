<?php
declare(strict_types=1);

namespace App\Framework;

/**
 * Class App
 * @package App\Framework
 */
class App
{
    private $controller = 'List';
    private $method = 'index';

    /**
     * @return false|string[]
     */
    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }


    public function loadController(): void
    {
        $URL = $this->splitURL();

        $filename = "../app/controllers/".ucfirst($URL[0]).".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {

            $filename = "../app/controllers/NotFoundController.php";
            require $filename;
            $this->controller = "NotFoundController";
        }

        $controller = new $this->controller;

        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        call_user_func_array([$controller, $this->method], $URL);
    }

}


