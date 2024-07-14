<?php declare(strict_types=1);

/**
 * Model for error messages
 */
class ErrorModel
{
    /** @var string $message Text to display */
    public string $message;

    /** @var string $template Path to template file */
    public string $template;

    /**
     * Construct ErrorModel
     *
     * @param string $message Text to display
     * @param string $template Path to the template file
     */
    public function __construct(string $template, string $message)
    {
        $this->message = $message;
        $this->template = $template;
    }
}
