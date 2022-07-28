<?php

namespace Tsoft\Core;

class Controller
{

    public function input($column = false, $default = '')
    {
        $data = [];
        foreach ($_REQUEST as $key => $value) {
            $data[$key] = strip_tags($value);
        }

        return $column ? $data[$column] ?? $default : $data;

    }

}