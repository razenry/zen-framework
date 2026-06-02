<?php

namespace App\Core;

class Route
{
    private static $routes = [];
    private static $namedRoutes = [];
    private static $lastRouteIndex = null;

    public static function get($uri, $callback)
    {
        return self::add('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        return self::add('POST', $uri, $callback);
    }

    private static function add($method, $uri, $callback)
    {
        $originalUri = $uri;
        // Simple regex to match dynamic parameters like {id}
        $uri = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri);
        self::$routes[] = [
            'method' => $method,
            'uri' => '#^' . $uri . '$#',
            'original_uri' => $originalUri,
            'callback' => $callback
        ];
        
        self::$lastRouteIndex = count(self::$routes) - 1;
        return new static();
    }

    public function name($name)
    {
        if (self::$lastRouteIndex !== null) {
            self::$namedRoutes[$name] = self::$routes[self::$lastRouteIndex]['original_uri'];
        }
        return $this;
    }

    public static function getUrl($name, $params = [])
    {
        if (!isset(self::$namedRoutes[$name])) {
            throw new \Exception("Route name '{$name}' not found.");
        }
        
        $uri = self::$namedRoutes[$name];
        foreach ($params as $key => $value) {
            $uri = str_replace('{' . $key . '}', $value, $uri);
        }
        
        return baseUrl($uri);
    }

    public static function resolve()
    {
        $uri = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match($route['uri'], $uri, $matches)) {
                array_shift($matches); // Remove the full match

                if (is_array($route['callback'])) {
                    // It's a controller and method e.g. [HomeController::class, 'index']
                    $controller = new $route['callback'][0]();
                    $action = $route['callback'][1];
                    call_user_func_array([$controller, $action], $matches);
                } elseif (is_callable($route['callback'])) {
                    // It's a closure
                    call_user_func_array($route['callback'], $matches);
                }
                return;
            }
        }

        // 404 Not Found
        $error = new \App\Controllers\ErrorController();
        $error->notFound();
    }
}
