<?php
declare(strict_types=1);

namespace App\Framework;

use App\Controllers\NotFoundController;
use App\Exceptions\ApiException;
use App\Exceptions\MethodNotFoundException;
use ArgumentCountError;
use Exception;
use http\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonException;

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
     * @return void
     * @throws MethodNotFoundException
     * @throws JsonException
     */
    public function loadController(): void
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

        $exitCode = 200;
        try {
            $reflection = new \ReflectionMethod($this->getControllerName(),$this->method);
            $methodParamsNumber = $reflection->getNumberOfRequiredParameters();
            if($methodParamsNumber !== count($this->getParams())){
                throw new InvalidArgumentException('Wrong argument number for method '.$this->method.' in '.$this->getControllerName());
            }

            $load = call_user_func_array([$controller, $this->method], $this->getParams());
            /*if ($load === false) {
                throw new MethodNotFoundException('Method "'.$this->method.'" not found in '.$this->getControllerName());
            }*/
        }
        catch (Exception $exception) {
            $apiException = $this->getApiException($exception);
            $load = $this->getExceptionArray($apiException);
            $exitCode = $apiException->getCode();
        }
        $this->returnHeaders();
        print json_encode($load, JSON_THROW_ON_ERROR);
        exit($exitCode);
    }

    /**
     * @return string[]
     */
    private function parseUrl(): array
    {
        $url = $this->getMethod() ?? 'Undefined';
        $this->url = explode('/', trim($url, '/'));
        return $this->url;
    }

    /**
     * @return string
     */
    private function getControllerName(): string
    {
        return ucfirst($this->parseUrl()[0]).'Controller';
    }

    /**
     * @return string
     * @throws MethodNotFoundException
     */
    private function getMethodName(): string
    {
        if (!isset($this->parseUrl()[1])) {
            throw new MethodNotFoundException('Method "'.$this->parseUrl()[1].'" not found in '.$this->getControllerName(), 404);
        }
        return $this->parseUrl()[1];
    }

    /**
     * @param  string  $controller
     * @return bool
     */
    protected function isControllerExist(string $controller): bool
    {
        return file_exists('../app/Controllers/'.ucfirst($controller).'.php');
    }

    /**
     * @return void
     */
    protected function returnHeaders(): void
    {
        header('Content-Type: application/json', false);
        header('Access-Control-Allow-Origin: *', false); //https://chopshop-app.netlify.app/');
        header('Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type, Accept,X-Auth-Token,Authorization,Access-Control-Allow-Credentials,Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin');
        header('Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE,OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        header('Vary: Accept-Encoding');
    }

    /**
     * @return mixed
     */
    protected function getMethod(): mixed
    {
        return $_GET['method'];
    }

    /**
     * @param  Exception  $exception
     * @return ApiException
     */
    #[Pure]
    protected function getApiException(Exception $exception): ApiException
    {
        if (DEBUG) {
            $apiException = new ApiException($exception->getMessage(), 500, $exception);
        } else {
            $apiException = new ApiException('Failed', 500);
        }
        return $apiException;
    }

    /**
     * @param  Exception  $exception
     * @return array[]
     */
    #[Pure]
    #[ArrayShape(['exception' => "array"])]
    protected function getExceptionArray(Exception $exception): array
    {
        return [
            'exception' => [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'object' => $exception,
                'trace' => $exception->getTraceAsString()
            ]
        ];
    }

    /**
     * @return string[]
     */
    protected function getParams(): array
    {
        $params = $this->parseUrl();
        unset($params[0], $params[1]);
        return $params;
    }
}


