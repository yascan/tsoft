<?php

namespace Tsoft\Core\Helpers;

class Redirect
{
    /**
     * @param string $toUrl
     * @param int $status
     * @return void
     */
    public static function to(string $toUrl, int $status = 301)
    {
        header('location:' . getenv('BASE_PATH') .  $toUrl, true, $status);
    }
}