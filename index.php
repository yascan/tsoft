<?php

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

use \Tsoft\Core\Route;

require __DIR__ . '/App/routes/wep.php';

Route::dispatch();