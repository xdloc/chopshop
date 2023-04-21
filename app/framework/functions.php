<?php
declare(strict_types=1);

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . APP_ROOT."/".$path);
	die;
}

//todo
function env(){

}