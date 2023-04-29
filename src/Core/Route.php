<?php

namespace App\Core;

final class Route
{
    public function __construct(
        private string $method,
        private string $path,
        private string $controller,
        private string $function,
        private array $middlewares = [],
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function isMethodMatch(string $requestMethod): bool
    {
        return $this->method === $requestMethod;
    }

    public function pathMatch(string $pattern, string $requestPath, array &$params): bool
    {
        return preg_match($pattern, $requestPath, $params);
    }
}
