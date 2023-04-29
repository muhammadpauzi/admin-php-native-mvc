<?php

namespace App\Core;

final class Request
{
    private array $params = [];

    private function resolveDefault(array $requests, string $key, mixed $default)
    {
        return isset($requests[$key]) ? $requests[$key] : $default;
    }

    private function escape(?string $value)
    {
        return is_string($value) ? htmlspecialchars($value) : $value;
    }

    public function find(string $key, mixed $default = null)
    {
        return $this->escape($this->resolveDefault(array_merge($_GET, $_POST), $key, $default));
    }

    public function get(string $key, mixed $default = null)
    {
        return $this->escape($this->resolveDefault($_GET, $key, $default));
    }

    public function post(string $key, mixed $default = null)
    {
        return $this->escape($this->resolveDefault($_POST, $key, $default));
    }

    public function all()
    {
        return array_merge($_GET, $_POST);
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getAllParams(): array
    {
        return $this->params;
    }

    public function getParams(mixed $key = null, mixed $default = null): mixed
    {
        return isset($this->params[$key]) ? $this->params[$key] : $default;
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isDelete(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    public function isPut(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    public function getCurrentRequestPath()
    {
        return $this->get('path', Config::config("request.default_path"));
    }

    public function pushParams(array $params): void
    {
        array_shift($params);
        $this->params = $params;
    }
}
