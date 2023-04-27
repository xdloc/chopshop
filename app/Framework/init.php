<?php
declare(strict_types=1);

require '../../vendor/autoload.php';


require 'config.php';
\Sentry\init(['dsn' => config('SENTRY_URL')]);
require 'functions.php';

/*require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';*/