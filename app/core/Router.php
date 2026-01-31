<?php

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, $handler, array $options = []): void
    {
        $this->addRoute('GET', $path, $handler, $options);
    }

    public function post(string $path, $handler, array $options = []): void
    {
        $this->addRoute('POST', $path, $handler, $options);
    }

    private function addRoute(string $method, string $path, $handler, array $options): void
    {
        $path = $this->normalizePath($path);
        $paramNames = [];
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($matches) use (&$paramNames) {
            $paramNames[] = $matches[1];
            return '([\w-]+)';
        }, $path);

        $this->routes[$method][] = [
            'path' => $path,
            'pattern' => '#^' . $pattern . '$#',
            'handler' => $handler,
            'options' => $options,
            'params' => $paramNames,
        ];
    }

    public function dispatch(string $method, string $path): void
    {
        $path = $this->normalizePath($path);
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route) {
            if (!preg_match($route['pattern'], $path, $matches)) {
                continue;
            }

            array_shift($matches);
            $params = [];
            foreach ($route['params'] as $index => $name) {
                $params[$name] = $matches[$index] ?? null;
            }

            $options = $route['options'] ?? [];
            if (($options['guest'] ?? false) && Auth::check()) {
                redirect(url('dashboard'));
            }
            if (($options['auth'] ?? false) && !Auth::check()) {
                redirect(url('login'));
            }
            if (!empty($options['permission'])) {
                RBAC::require($options['permission']);
            }
            if ($method === 'POST' && ($options['csrf'] ?? true)) {
                $token = $_POST['_token'] ?? null;
                if (!Csrf::check($token)) {
                    Response::abort(403, 'Token de seguranca invalido.');
                }
            }

            $handler = $route['handler'];
            if (is_array($handler)) {
                [$class, $methodName] = $handler;
                $controller = new $class();
                $controller->{$methodName}($params);
                return;
            }

            if (is_callable($handler)) {
                $handler($params);
                return;
            }
        }

        Response::abort(404, 'Pagina nao encontrada.');
    }

    private function normalizePath(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }
        return $path;
    }
}
