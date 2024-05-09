<?php
function load_core($className)
{
	$filename = '../app/core/' . $className . '.php';
	if (file_exists($filename)) {
		require_once $filename;
	}
}

spl_autoload_register('load_core');
