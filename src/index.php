<?php declare (strict_types = 1);

require '../vendor/autoload.php';

// load environment variables if src/.env exists
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// set content type
header("Content-type: image/svg+xml");

// set cache to refresh once per day
$timestamp = gmdate("D, d M Y 23:59:00") . " GMT";
header("Expires: $timestamp");
header("Last-Modified: $timestamp");
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");

// redirect to demo site if no text is given
if (!isset($_REQUEST["lines"])) {
    header('Location: demo/');
    exit;
}

try {
    // create renderer model
    $model = new RendererModel("templates/main.php", $_REQUEST);
    // create renderer view
    $view = new RendererView($model);
} catch (Exception $error) {
    // create error rendering model
    $model = new ErrorModel("templates/error.php", $error->getMessage());
    // create error rendering view
    $view = new ErrorView($model);
}

// render SVG
echo $view->render();
