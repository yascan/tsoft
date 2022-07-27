<?php

namespace Tsoft\Core;

class View
{
    /**
     * @param string $viewName
     * @param array $data
     * @return string
     */
    public static function show(string $viewName, array $data = []): string
    {
        extract($data);
        $viewName = str_replace('.', '/', $viewName);
        ob_start();
        require dirname(__DIR__) . '/public/views/' . $viewName . '.php';
        return ob_get_clean();
    }
}