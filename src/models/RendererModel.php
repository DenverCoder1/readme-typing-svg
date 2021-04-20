<?php declare (strict_types = 1);

/**
 * Model for SVG outputs
 */
class RendererModel
{
    /** @var array<string> $lines text to display */
    public $lines;

    /** @var string $font font family */
    public $font;

    /** @var string $color font color */
    public $color;

    /** @var int $size font size */
    public $size;

    /** @var bool $center whether or not to center text */
    public $center;

    /** @var int $width SVG width (px) */
    public $width;

    /** @var int $height SVG height (px) */
    public $height;

    /** @var array<string, string> $DEFAULTS */
    private $DEFAULTS = array(
        "font" => "JetBrains Mono",
        "color" => "#36BCF7",
        "size" => "20",
        "center" => "false",
        "width" => "400",
        "height" => "50",
    );

    /**
     * Construct RendererModel
     *
     * @param string $template path to the template file
     * @param array<string, string> $params request parameters
     */
    public function __construct($template, $params)
    {
        $this->lines = $this->checkLines($params["lines"] ?? "");
        $this->font = $this->checkFont($params["font"] ?? $this->DEFAULTS["font"]);
        $this->color = $this->checkColor($params["color"] ?? $this->DEFAULTS["color"]);
        $this->size = $this->checkNumber($params["size"] ?? $this->DEFAULTS["size"], "Font size");
        $this->center = $this->checkCenter($params["center"] ?? $this->DEFAULTS["center"]);
        $this->width = $this->checkNumber($params["width"] ?? $this->DEFAULTS["width"], "Width");
        $this->height = $this->checkNumber($params["height"] ?? $this->DEFAULTS["height"], "Height");
        $this->template = $template;
    }

    /**
     * Validate lines and return array of string
     *
     * @param string $lines - semicolon separated lines parameter
     * @return array<string>
     */
    private function checkLines($lines)
    {
        if (!$lines) {
            throw new InvalidArgumentException("Lines parameter must be set.");
        }
        $exploded = explode(";", $lines);
        return array_map("urldecode", $exploded);
    }

    /**
     * Validate font family and return valid string
     *
     * @param string $font - font name parameter
     * @return string
     */
    private function checkFont($font)
    {
        // return escaped font name
        return urldecode(preg_replace("/[^0-9A-Za-z+'\-()!&*_ ]/", "", $font));
    }

    /**
     * Validate font color and return valid string
     *
     * @param string $color - color parameter
     * @return string
     */
    private function checkColor($color)
    {
        $escaped = (string) preg_replace("/[^0-9A-Fa-f]/", "", $color);
        // if color is not a valid length, use the default
        if (!in_array(strlen($escaped), [3, 4, 6, 8])) {
            return $this->DEFAULTS["color"];
        }
        // return escaped color
        return "#" . $escaped;
    }

    /**
     * Validate numeric parameter and return valid integer
     *
     * @param string $num - parameter to validate
     * @param string $field - field name for displaying in case of error
     * @return int
     */
    private function checkNumber($num, $field)
    {
        $digits = intval(preg_replace("/[^0-9\-]/", "", $num));
        if ($digits <= 0) {
            throw new InvalidArgumentException("$field must be a positive number.");
        }
        return $digits;
    }

    /**
     * Validate center alignment and return boolean
     *
     * @param string $center - center parameter
     * @return boolean
     */
    private function checkCenter($center)
    {
        return isset($center) ? ($center == "true") : $this->DEFAULTS["center"];
    }
}
