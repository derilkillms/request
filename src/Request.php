<?php
/**
 * Author   : Muhammad Deril
 * URI      : http://www.derillab.com
 * Github   : @derilkillms
 */


namespace Derilkillms\Http;

class Request
{
    protected array $data = [];
    protected array $session = [];
    protected string $method;

    public function __construct()
    {
        $this->method  = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->session = $_SESSION ?? [];

        // Parse semua method
        $this->data['GET']     = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
        $this->data['POST']    = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
        $this->data['PUT']     = $this->parseBody('PUT');
        $this->data['PATCH']   = $this->parseBody('PATCH');
        $this->data['DELETE']  = $this->parseBody('DELETE');
        $this->data['OPTIONS'] = $this->parseBody('OPTIONS');
        $this->data['HEAD']    = $this->parseBody('HEAD');
    }

    protected function parseBody(string $method): array
    {
        if ($this->method === $method) {
            $raw = file_get_contents('php://input');
            if ($this->isJson()) {
                return json_decode($raw, true) ?? [];
            }
            parse_str($raw, $vars);
            return filter_var_array($vars, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
        }
        return [];
    }

    protected function isJson(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) &&
               stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }

    // Akses method spesifik
    public function get(string $key = null, $default = null)
    {
        return $this->fetch('GET', $key, $default);
    }

    public function post(string $key = null, $default = null)
    {
        return $this->fetch('POST', $key, $default);
    }

    public function put(string $key = null, $default = null)
    {
        return $this->fetch('PUT', $key, $default);
    }

    public function patch(string $key = null, $default = null)
    {
        return $this->fetch('PATCH', $key, $default);
    }

    public function delete(string $key = null, $default = null)
    {
        return $this->fetch('DELETE', $key, $default);
    }

    public function options(string $key = null, $default = null)
    {
        return $this->fetch('OPTIONS', $key, $default);
    }

    public function head(string $key = null, $default = null)
    {
        return $this->fetch('HEAD', $key, $default);
    }

    // Session
    public function session(string $key = null, $default = null)
    {
        return $this->fetchArray($this->session, $key, $default);
    }

    public function setSession(string $key, $value): void
    {
        $_SESSION[$key] = $value;
        $this->session[$key] = $value;
    }

    // Generic fetch
    protected function fetch(string $method, ?string $key, $default)
    {
        $array = $this->data[$method] ?? [];
        return $this->fetchArray($array, $key, $default);
    }

    protected function fetchArray(array $array, ?string $key, $default)
    {
        if ($key === null) {
            return $array;
        }
        return $array[$key] ?? $default;
    }

    // Info tambahan
    public function method(): string
    {
        return $this->method;
    }

    public function all(string $method = null): array
    {
        if ($method === null) {
            return $this->data[$this->method] ?? [];
        }
        return $this->data[strtoupper($method)] ?? [];
    }
}
