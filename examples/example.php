<?php
require 'vendor/autoload.php';

$router = new Router\Router('/php-router');

$router->add('/hello/([a-zA-Z]+)', function ($name) {
    echo sprintf('<h1>Hi %s</h1>', $name);
});

$router->add("/(.*)", function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - Not found</h1>';
});

$router->route();
?>