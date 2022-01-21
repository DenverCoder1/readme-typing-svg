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
    public function render()
    {
        // import variables into symbol table
        extract(array(
            "lines" => $this->model->lines,
            "font" => $this->model->font,
            "color" => $this->model->color,
            "size" => $this->model->size,
            "center" => $this->model->center,
            "vCenter" => $this->model->vCenter,
            "width" => $this->model->width,
            "height" => $this->model->height,
            "multiline" => $this->model->multiline,
            "fontCSS" => $this->model->fontCSS,
            "duration" => $this->model->duration,
        ));
        // render SVG with output buffering
        ob_start();
        include $this->model->template;
        $output = ob_get_contents();
        ob_end_clean();
        // return rendered output
        return $output;
    }
}
