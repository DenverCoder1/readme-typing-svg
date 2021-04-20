<?php declare (strict_types = 1);

require_once "models/RendererModel.php";
require_once "views/RendererView.php";

// set content type
header("Content-type: image/svg+xml");

try {
    // create renderer model
    $model = new RendererModel("templates/main.php", $_REQUEST);
} catch (InvalidArgumentException $error) {
    // display error svg
    $message = $error->getMessage();
    require_once "templates/error.php";
    exit;
}

// create renderer view
$view = new RendererView($model);

// render SVG
echo $view->output();
