<?php declare (strict_types = 1);

require '../vendor/autoload.php';

// load environment variables if .env exists
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$controller = new RendererController($_REQUEST);
$controller->setHeaders();
echo $controller->render();
