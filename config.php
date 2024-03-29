<?php



// Http Url
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('HTTP_URL', '/'. substr_replace(trim($_SERVER['REQUEST_URI'], '/'), '', 0, strlen($scriptName)));

// Define Path Application
define('SCRIPT', str_replace('\\', '/', rtrim(__DIR__, '/')) . '/');
//define('SYSTEM', SCRIPT . 'System/');
define('CONTROLLERS', SCRIPT . 'App/Controllers/');
define('MODELS', SCRIPT . 'App/Models/');
//define('UPLOAD', SCRIPT . 'Upload/');

// Config Database
define('DATABASE', [
    'Port'   => '3306',
    'Host'   => 'localhost',
    'Driver' => 'PDO',
    'Name'   => 'simple-mvc',
    'User'   => 'root',
    'Pass'   => '',
    'Prefix' => 'sm_'
]);

// DB_PREFIX
define('DB_PREFIX', 'sm_');
