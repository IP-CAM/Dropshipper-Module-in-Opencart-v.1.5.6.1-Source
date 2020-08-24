<?php
	define('ROOT_PATH',dirname(__FILE__));


	// DIR
	define('DIR_APPLICATION', ROOT_PATH . '/catalog/');
	define('DIR_SYSTEM', ROOT_PATH . '/system/');
	define('DIR_DATABASE', ROOT_PATH . '/system/database/');
	define('DIR_LANGUAGE', ROOT_PATH . '/catalog/language/');
	define('DIR_TEMPLATE', ROOT_PATH . '/catalog/view/theme/');
	define('DIR_CONFIG', ROOT_PATH . '/system/config/');
	define('DIR_IMAGE', ROOT_PATH . '/image/');
	define('DIR_CACHE', ROOT_PATH . '/system/cache/');
	define('DIR_DOWNLOAD', ROOT_PATH . '/download/');
	define('DIR_LOGS', ROOT_PATH . '/system/logs/');

	switch(isset($_SERVER['DEV_ENV']) ? $_SERVER['DEV_ENV'] : 'production' )
	{

		case 'tufan_laptop':

			define('HTTP_SERVER', 'http://buradasatiliyor.dev/');
			define('HTTPS_SERVER', 'http://buradasatiliyor.dev/');

			define('DB_DRIVER', 'mysqli');
			define('DB_HOSTNAME', 'localhost');
			define('DB_USERNAME', 'root');
			define('DB_PASSWORD', '');
			define('DB_DATABASE', 'buradasatiliyor');
			define('DB_PREFIX', 'oc_');
			break;

		default:

			define('HTTP_SERVER', 'http://buradasatiliyor.com/');
			define('HTTPS_SERVER', 'https://buradasatiliyor.com/');

			define('DB_DRIVER', 'mysql');
			define('DB_HOSTNAME', '94.73.144.252');
			define('DB_USERNAME', 'erikrende.com');
			define('DB_PASSWORD', 'Erikrende11');
			define('DB_DATABASE', 'buradasatiliyor');
			define('DB_PREFIX', 'oc_');


			break;

	}

