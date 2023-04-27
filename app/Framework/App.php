<?php
declare(strict_types=1);

namespace App\Framework;

use App\Controllers\NotFoundController;
use App\Exceptions\MethodNotFoundException;

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
        if (!empty($this->url)) {
            return $this->url;
        }
        $url = $_GET['method'] ?? 'Undefined';
        $this->url = explode('/', trim($url, '/'));
        return $this->url;
    }

    /**
     * @return string
     */
    private function getControllerName(): string
    {
        return ucfirst($this->getUrl()[0]).'Controller';
    }

    /**
     * @return string
     * @throws MethodNotFoundException
     */
    private function getMethodName(): string
    {
        if (!isset($this->getUrl()[1])) {
            throw new MethodNotFoundException('Method "'.$this->getUrl()[1].'" not found in '.$this->getControllerName(), 404);
        }
        return $this->getUrl()[1];
    }

    /**
     * @return mixed
     * @throws MethodNotFoundException
     * @throws \JsonException
     */
    public function loadController(): mixed
    {
        $controller = $this->getControllerName();
        $method = $this->getMethodName();

        if ($this->isControllerExist($controller)) {
            $this->controller = 'App\Controllers\\'.$controller;
        } else {
            $this->controller = NotFoundController::class;
        }

        $controller = new $this->controller;

        if (!empty($method) && method_exists($controller, $method)) {
            $this->method = $method;
        }

        $load = call_user_func_array([$controller, $this->method], $this->getUrl());
        if ($load === false) {
            throw new MethodNotFoundException('Method "'.$this->method.'" not found in '.$controller);
        }

        header("Content-Type: application/json");
        print json_encode($load, JSON_THROW_ON_ERROR);
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


