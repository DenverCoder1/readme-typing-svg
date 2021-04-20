<?php declare (strict_types = 1);

require_once "models/RendererModel.php";
require_once "views/RendererView.php";

// set content type
header("Content-type: image/svg+xml");

$model = new RendererModel();
$view = new RendererView($model);

// render SVG
echo $view->output();
