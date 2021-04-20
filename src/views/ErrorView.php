<?php declare (strict_types = 1);

/**
 * View for rendering error messages
 */
class ErrorView
{
    /**
     * @var ErrorModel $model
     */
    private $model;

    /**
     * Constructor for Error View
     * @param ErrorModel $model
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
        // import variables into symbol table
        extract(["message" => $this->model->message]);
        // render SVG with output buffering
        ob_start();
        require_once $this->model->template;
        $output = ob_get_contents();
        ob_end_clean();
        // return rendered output
        return $output;
    }
}
