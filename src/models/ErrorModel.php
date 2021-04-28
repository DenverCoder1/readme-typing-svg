<?php declare (strict_types = 1);

/**
 * Model for error messages
 */
class ErrorModel
{
    /** @var string $message Text to display */
    public $message;

    /** @var string $template Path to template file */
    public $template;

    /**
     * Construct ErrorModel
     *
     * @param string $message Text to display
     * @param string $template Path to the template file
     */
    public function __construct($template, $message)
    {
        $this->message = $message;
        $this->template = $template;
    }
}
