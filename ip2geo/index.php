<?php
/**
 * Autoload
 */
spl_autoload_register(function ($className) {
    include "./src/$className.php";
});

/**
 * Init
 */
if (isset($_GET['ip'])) {
	header('Content-Type: application/json');

	$geo = new GeoIP($_GET['ip']);
	echo $geo->getInfo();
} else {
	header("Status: 404 Not Found");
	die(json_encode(['error' => 'no ip']));
}

