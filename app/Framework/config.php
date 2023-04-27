<?php
declare(strict_types=1);

//you can add more config files here
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $config = require '../../../config/app.local.php';
} else {
    $config = require '../../../config/app.php';
}
define('CONFIG',$config);
/*foreach($config as $var => $value){
    define($var, $value);
}*/

define('DB_NAME', $config['DB_NAME']);
define('DB_HOST', $config['DB_HOST']);
define('DB_USER', $config['DB_USER']);
define('DB_PASS', $config['DB_PASSWORD']);
define('DB_DRIVER', $config['DB_CONNECTION']);

define('APP_ROOT', $config['APP_ROOT']);

define('SENTRY_URL',$config['SENTRY_URL']);
define('APP_NAME', $config['APP_NAME']);

define('DEBUG', $config['APP_DEBUG']);
define('DB_TIME_FORMAT',$config['DB_TIME_FORMAT']);
