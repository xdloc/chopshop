<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

/**
 * @param $stuff
 * @return void
 */
function show($stuff): void
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

/**
 * @param $str
 * @return string
 */
function esc($str): string
{
	return htmlspecialchars($str);
}

/**
 * @param $path
 * @return void
 */
#[NoReturn] function redirect($path): void
{
	header("Location: " . APP_ROOT."/".$path);
	die;
}

//todo
function config(string $var, string $default = ''){
    return require CONFIG['var'];
}