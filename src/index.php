<?php declare (strict_types = 1);

require '../vendor/autoload.php';

// set content type
header("Content-type: image/svg+xml");

try {
    // create renderer model
    $model = new RendererModel("templates/main.php", $_REQUEST);
    // create renderer view
    $view = new RendererView($model);
} catch (InvalidArgumentException $error) {
    // create error rendering model
    $model = new ErrorModel("templates/error.php", $error->getMessage());
    // create error rendering view
    $view = new ErrorView($model);
}

// render SVG
echo $view->output();
