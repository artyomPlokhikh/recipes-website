<?php

require("functions.php");
require_once("config.php");



$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$routes = [
    '/~plokhart/' => 'controllers/index.php',
    '/~plokhart/registration' => 'controllers/registration.php',
    '/~plokhart/authenticate' => 'controllers/authenticate.php',
    '/~plokhart/upload' => 'controllers/upload.php',
    '/~plokhart/edit' => 'controllers/edit.php',
    '/~plokhart/recipe' => 'controllers/recipe.php',
    '/~plokhart/profile'=> 'controllers/profile.php',
    '/~plokhart/profile/settings'=> 'controllers/profileSettings.php',
];


if (array_key_exists($uri, $routes)) {
    require(__DIR__ . "/" . $routes[$uri]);
} else {
    http_response_code(404);
    require(__DIR__ . '/views/404.php');
}
