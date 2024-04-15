<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

// start the session before anything else
session_start();

// constants
define("VIEWS_PATH", __DIR__ . "/../views" .  DIRECTORY_SEPARATOR);

$router = new App\Router();

$router
    ->get("/", [App\Controllers\Home::class, 'index'])
    ->get("/blogs", [App\Controllers\Blogs::class, 'index'])
    ->get("/blogs/compose", [App\Controllers\Blogs::class, 'compose'])
    ->post("/blogs/compose", [App\Controllers\Blogs::class, 'store'])
    ->get("/about", [App\Controllers\About::class, 'index']);
    

echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));