<?php

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function __construct(private Request $request)
    {
    }

    public function get(string $path, string $controller, string $function, array $middlewares = [])
    {
        $this->add('GET', $path, $controller, $function, $middlewares);
    }

    public function post(string $path, string $controller, string $function, array $middlewares = [])
    {
        $this->add('POST', $path, $controller, $function, $middlewares);
    }

    public function add(
        string $method,
        string $path,
        string $controller,
        string $function,
        array  $middlewares = []
    ): void {
        $this->routes[] = new Route(
            $method,
            $path,
            $controller,
            $function,
            $middlewares
        );
    }

    public function run(): void
    {
        $path = $this->request->getCurrentRequestPath();
        $method = $this->request->getMethod();
        $params = [];

        foreach ($this->routes as $route) {
            $pattern = $this->getPattern($route->getPath());

            if ($route->pathMatch($pattern, $path, $params) && $route->isMethodMatch($method)) {

                $this->callBeforeMiddlewares($route);

                $this->request->pushParams($params);

                $this->callController($route);

                $this->callAfterMiddlewares($route);

                return;
            }
        }

        http_response_code(404);
        echo 'CONTROLLER NOT FOUND';
    }

    private function callController(Route $route): void
    {
        $arguments = [
            $this->request
        ];

        $instanceController = new ($route->getController());
        $functionName = $route->getFunction();

        call_user_func_array([
            $instanceController, $functionName
        ], $arguments);
    }

    private function callBeforeMiddlewares(Route $route): void
    {
        foreach ($route->getMiddlewares() as $middleware) {
            $instance = new $middleware;
            $instance->before();
        }
    }

    private function callAfterMiddlewares(Route $route): void
    {
        foreach ($route->getMiddlewares() as $middleware) {
            $instance = new $middleware;
            $instance->after();
        }
    }

    private function getPattern(string $pathPatern)
    {
        $pathPatern = str_replace('/', '\/', $pathPatern);

        foreach ([":num", ":alpha", ":alphanum"] as $key) {
            $reqex = match ($key) {
                ':num' => '([0-9]+)',
                ':alpha' => '([a-zA-Z]+)',
                ':alphanum' => '([0-9a-zA-Z]+)',
            };

            $pathPatern = preg_replace("/\(" . $key . "\)/", $reqex, $pathPatern);
        }

        return sprintf("/^%s$/", $pathPatern);
    }
}
