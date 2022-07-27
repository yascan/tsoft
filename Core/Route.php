<?php

namespace Tsoft\Core;

use Tsoft\Core\Helpers\Redirect;

class Route
{
    public static array $patterns = [
        '{id[0-9]?}' => '([0-9]+)',
        '{url[0-9]?}' => '([0-9a-zA-Z-_]+)'
    ];
    public static bool $hasRoute = false;
    public static array $routes = [];
    public static string $prefix = '';

    /**
     * @param $path
     * @param $callback
     * @return Route
     */
    public static function get($path, $callback): Route
    {
        self::$routes['get'][self::$prefix . $path] = [
            'callback' => $callback
        ];
        return new self();
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public static function post($path, $callback){
        self::$routes['post'][$path] = [
            'callback' => $callback
        ];
    }

    public static function dispatch(){
        $url = self::getUrl();
        $method = self::getMethod();
        foreach (self::$routes[$method] as $path => $props){
            foreach (self::$patterns as $key => $pattern){
                $path = preg_replace('#' . $key . '#', $pattern, $path);
            }
            $pattern = '#^' . $path . '$#';
            if (preg_match($pattern, $url, $params)){
                self::$hasRoute = true;
                array_shift($params);
                if (isset($props['redirect'])){
                    Redirect::to($props['redirect'], $props['status']);
                } else{
                    $callback = $props['callback'];
                    if (is_callable($callback)){
                        echo call_user_func_array($callback, $params);
                    } elseif (is_string($callback)){
                        [$controllerName, $methodName] = explode('@', $callback);
                        $controllerName = 'Tsoft\App\Controllers\\' . $controllerName;
                        $controller = new $controllerName();
                        echo call_user_func_array([$controller, $methodName], $params);
                    }
                }
            }
        }
        self::hasRoute();
    }

    /**
     * @return void
     */
    public static function hasRoute(){
        if (self::$hasRoute === false){
            die("Sayfa bulunamadı");
        }
    }

    /**
     * @return string
     */
    public static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string
     */
    public static function getUrl(): string
    {
        return str_replace(getenv('BASE_PATH'),null,$_SERVER['REQUEST_URI']);
    }

    /**
     * @param $name
     * @return void
     */
    public function name($name)
    {
        $key = array_key_last(self::$routes['get']);
        self::$routes['get'][$key]['name']= $name;
    }

    /**
     * @param $name
     * @param array $params
     * @return array|int|string|string[]|null
     */
    public static function url($name, array $params = [])
    {
        $route = array_key_first(array_filter(self::$routes['get'], function ($route) use($name){
            return isset($route['name']) && $route['name'] === $name;
        }));
        return getenv('BASE_PATH') . str_replace(array_keys($params), array_values($params), $route);
    }

    /**
     * @param $prefix
     * @return Route
     */
    public static function prefix($prefix): Route
    {
        self::$prefix = $prefix;
        return new self();
    }

    /**
     * @param \Closure $closure
     * @return Void
     */
    public static function group(\Closure $closure): Void
    {
        $closure();
        self::$prefix = '';
    }

    public static function redirect($from, $to, $status = 301)
    {
        self::$routes['get'][$from] = [
            'redirect' => $to,
            'status' => $status
        ];
    }
}