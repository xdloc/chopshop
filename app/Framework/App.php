<?php
declare(strict_types=1);

namespace App\Framework;

use App\Controllers\NotFoundController;

/**
 * Class App
 * @package App\Framework
 */
class App
{
    private string $controller = '';
    private string $method = '';

    /**
     * @var string[]
     */
    private array $url = [];

    /**
     * @return string[]
     */
    private function getUrl(): array
    {
        if(!empty($this->url)){
            return $this->url;
        }
        $url = $_GET['url'] ?? '';
        $this->url = explode('/', trim($url, '/'));
        return $this->url;
    }

    /**
     * @return string
     */
    private function getControllerName(): string
    {
        return ucfirst($this->getUrl()[0]);
    }

    /**
     * @return string
     */
    private function getMethodName(): string
    {
        return $this->getUrl()[1];
    }

    public function loadController(): void
    {
        $controller = $this->getControllerName();
        $method = $this->getMethodName();

        if ($this->isControllerExist($controller)) {
            $this->controller = $controller;
        } else {
            $this->controller = NotFoundController::class;
        }

        $controller = new $this->controller;

        if (!empty($URL[1]) && method_exists($controller, $method)) {
            $this->method = $method;
        }

        call_user_func_array([$controller, $this->method], $this->getUrl());
    }

    /**
     * @param  string  $controller
     * @return bool
     */
    protected function isControllerExist(string $controller): bool
    {
        return file_exists('../app/Controllers/'.ucfirst($controller).'.php');
    }

}


