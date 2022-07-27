<?php

if (!function_exists('route')){
    /**
     * @param string $name
     * @param array $params
     * @return array|int|string|string[]|null
     */
    function route(string $name, array $params=[]){
        return \Tsoft\Core\Route::url($name, $params);
    }
}

if (!function_exists('view')){
    /**
     * @param string $name
     * @param array $data
     * @return string
     */
    function view(string $name, array $data = []): string
    {
        return \Tsoft\Core\View::show($name, $data);
    }
}

if (!function_exists('url')){
    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    function url(string $name, array $params = []): string
    {
        return \Tsoft\Core\Route::url($name, $params);
    }
}