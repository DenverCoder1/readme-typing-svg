<?php declare (strict_types = 1);

/**
 * Controller for choosing model and rendering SVG outputs
 */
class RendererController
{

    /**
     * @var RendererModel $model
     */
    private $model;

    /**
     * @var RendererView $view
     */
    private $view;

    /**
     * @var array<string, string> $params
     */
    private $params;

    /**
     * Construct RendererController
     *
     * @param array<string, string> $params request parameters
     */
    public function __construct($params)
    {
        $this->params = $params;

        // set up model and view
        try {
            // create renderer model
            $this->model = new RendererModel(__DIR__ . "/../templates/main.php", $params);
            // create renderer view
            $this->view = new RendererView($this->model);
        } catch (Exception $error) {
            // create error rendering model
            $this->model = new ErrorModel(__DIR__ . "/../templates/error.php", $error->getMessage());
            // create error rendering view
            $this->view = new ErrorView($this->model);
        }
    }

    /**
     * Redirect to the demo site
     */
    private function redirectToDemo(): void
    {
        header('Location: demo/');
        exit;
    }

    /**
     * Set content type for page output
     */
    private function setContentType($type): void
    {
        header("Content-type: {$type}");
    }

    /**
     * Set cache to refresh periodically
     * This ensures any updates will roll out to all profiles
     */
    private function setCacheRefreshDaily(): void
    {
        // set cache to refresh once per day
        $timestamp = gmdate("D, d M Y 23:59:00") . " GMT";
        header("Expires: $timestamp");
        header("Last-Modified: $timestamp");
        header("Pragma: no-cache");
        header("Cache-Control: no-cache, must-revalidate");
    }

    /**
     * Set output headers
     */
    public function setHeaders(): void
    {
        // redirect to demo site if no text is given
        if (!isset($this->params["lines"])) {
            $this->redirectToDemo();
        }

        // set the content type header
        $this->setContentType("image/svg+xml");

        // set cache headers
        $this->setCacheRefreshDaily();
    }

    /**
     * Get the rendered SVG
     *
     * @return string The SVG to output
     */
    public function render(): string
    {
        return $this->view->render();
    }
}
