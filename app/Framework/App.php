<?php
declare(strict_types=1);

namespace App\Framework;

use App\Controllers\NotFoundController;
use App\Exceptions\ApiException;
use App\Exceptions\MethodNotFoundException;
use ArgumentCountError;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonException;

/**
 * Class App
 * @package App\Framework
 */
class App
{
    private const CONTROLLER_NAMESPACE = 'App\Controllers\'';
    private string $controller = '';
    private string $method = '';

    /**
     * @var string[]
     */
    private array $url = [];
    private array $parsedUri = [];

    /**
     * @return void
     * @throws MethodNotFoundException
     * @throws JsonException
     */
    public function loadController(): void
    {
        $this->parseUrl();

        if ($this->isControllerExist($this->getControllerName())) {
            $this->controller = 'App\Controllers\\'.$this->getControllerName();
        } else {
            $this->controller = NotFoundController::class;
        }

        $controller = new $this->controller;

        if (empty($this->method) || !method_exists($controller, $this->method)) {
            throw new MethodNotFoundException('Method '.$this->method.' not exist');
        }

        $exitCode = 200;
        try {
            $reflection = new \ReflectionMethod($controller, $this->method);
            $methodParamsNumber = $reflection->getNumberOfRequiredParameters();
            if ($methodParamsNumber !== count($this->getParams())) {
                throw new ArgumentCountError('Wrong argument number for method '.$this->method.' in '.$this->getControllerName());
            }

            $load = call_user_func_array([$controller, $this->method], $this->getParams());
        } catch (Exception $exception) {
            $apiException = $this->getApiException($exception);
            $load = $this->getExceptionArray($apiException);
            $exitCode = $apiException->getCode();
        }
        $this->returnHeaders();
        print json_encode($load, JSON_THROW_ON_ERROR);
        exit($exitCode);
    }

    /**
     * @throws MethodNotFoundException
     */
    private function parseUrl(): void
    {
        $parsedUri = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parsedUri['query'], $query);
        $this->parsedUri = $query;

        try {
            $this->controller = $this->parsedUri['controller'];
        } catch (Exception $exception) {
            throw new MethodNotFoundException('Controller not set');
        }
        try {
            $this->method = $this->parsedUri['method'];
        } catch (Exception $exception) {
            throw new MethodNotFoundException('Method not set');
        }
    }

    /**
     * @return string
     */
    private function getControllerName(): string
    {
        return ucfirst($this->controller).'Controller';
    }

    /**
     * @return string
     */
    private function getMethodName(): string
    {
        return $this->method;
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
        $params = $this->parsedUri;
        unset($params['method'], $params['controller']);
        return $params;
    }
}


