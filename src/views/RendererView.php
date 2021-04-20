<?php declare (strict_types = 1);

/**
 * View for rendering typing SVG
 */
class RendererView
{
    /**
     * @var RendererModel $model
     */
    private $model;

    /**
     * Constructor for Renderer View
     * @param RendererModel $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Render SVG Output
     * @return string
     */
    public function output()
    {
        $lines = $this->model->lines;
        $font = $this->model->font;
        $color = $this->model->color;
        $size = $this->model->size;
        $center = $this->model->center;
        $width = $this->model->width;
        $height = $this->model->height;
        // render SVG with output buffering
        ob_start();
        require_once $this->model->template;
        $output = ob_get_contents();
        ob_end_clean();
        // return rendered output
        return $output;
    }
}
