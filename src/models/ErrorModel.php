<?php declare (strict_types = 1);

/**
 * Model for error messages
 */
class ErrorModel
{
    /** @var string $message text to display */
    public $message;

    /** @var string $template path to template file */
    public $template;

    /**
     * Construct ErrorModel
     *
     * @param string $message text to display
     * @param string $template path to the template file
     */
    public function __construct($template, $message)
    {
        $this->message = $message;
        $this->template = $template;
    }
}
