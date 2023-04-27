<?php
declare(strict_types=1);




require 'config.php';
require 'functions.php';
\Sentry\init(['dsn' => SENTRY_URL]);

/*require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';*/