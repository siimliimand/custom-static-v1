<?php

use App\Configuration\ConfigurationLoader;
use App\RequestHandler\Request;
use App\RequestHandler\RequestHandler;
use Rfussien\Dotenv\Loader;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__).'/vendor/autoload.php';

define('ROOT_PATH', __DIR__ . '/../');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('SRC_PATH', ROOT_PATH . 'src/');

require_once ROOT_PATH . 'include/global-functions.php';

$dotenv = new Loader(ROOT_PATH);
$dotenv->load();

$configurationLoader = new ConfigurationLoader();
$configurationLoader->load();

$request = new Request();
$requestHandler = new RequestHandler();
$requestHandler->handle($request);