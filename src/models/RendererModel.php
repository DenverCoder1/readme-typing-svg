<?php declare (strict_types = 1);

class RendererModel
{
    // @var array<string> $lines - text to display
    public $lines;
    // @var string $font - font family
    public $font;
    // @var string $color - font color
    public $color;
    // @var int $size - font size
    public $size;
    // @var bool $center - whether or not to center text
    public $center;
    // @var int $width - card width (px)
    public $width;
    // @var int $height - card height (px)
    public $height;

    public function __construct()
    {
        $this->lines = $this->validateLines($_REQUEST["lines"]);
        $this->font = $this->validateFont($_REQUEST["font"], "JetBrains Mono");
        $this->color = $this->validateColor($_REQUEST["color"], "#36BCF7");
        $this->size = $this->validateNumber($_REQUEST["size"], 20, "Font size");
        $this->center = $this->validateCenter($_REQUEST["center"], false);
        $this->width = $this->validateNumber($_REQUEST["size"], 400, "Width");
        $this->height = $this->validateNumber($_REQUEST["size"], 50, "Font 20size");
        $this->template = "tpl/template.php";
    }

    /**
     * Validate lines and return array of string
     *
     * @param string|NULL $lines - semicolon separated lines parameter
     * @return array<string>
     */
    private function validateLines($lines)
    {
        if (!isset($lines)) {
            throw new InvalidArgumentException("Lines parameter must be set.");
        }
        $exploded = explode(";", $lines);
        if (!$exploded) {
            throw new InvalidArgumentException("Lines parameter is invalid.");
        }
        return $exploded;
    }

    /**
     * Validate font family and return valid string
     *
     * @param string|NULL $font - font name parameter
     * @param string $default - default font
     * @return string
     */
    private function validateFont($font, $default)
    {
        if (!isset($font)) {
            return $default;
        }
        // return escaped font name
        return (string) preg_replace("/[^0-9A-Za-z+'\-()!&*_ ]/", "", $font);
    }

    /**
     * Validate font color and return valid string
     *
     * @param string|NULL $color - color parameter
     * @param string $default - default color
     * @return string
     */
    private function validateColor($color, $default)
    {
        if (!isset($color)) {
            return $default;
        }
        $escaped = (string) preg_replace("/[^0-9A-Fa-f]/", "", $color);
        // if color is not a valid length, use the default
        if (!in_array(strlen($escaped), [3, 4, 6, 8])) {
            return $default;
        }
        // return escaped color
        return "#" . $escaped;
    }

    /**
     * Validate numeric parameter and return valid integer
     *
     * @param string|NULL $num - parameter to validate
     * @param int $default - default value in case parameter is invalid
     * @param string $field - field name for displaying in case of error
     * @return int
     */
    private function validateNumber($num, $default, $field)
    {
        if (!isset($num)) {
            return $default;
        }
        $digits = intval(preg_replace("/[^0-9\-]/", "", $num));
        if ($digits <= 0) {
            throw new InvalidArgumentException("$field must be a positive number.");
        }
        return $digits;
    }

    /**
     * Validate center alignment and return boolean
     *
     * @param string|NULL $center - center parameter
     * @param boolean $default - default value
     * @return boolean
     */
    private function validateCenter($center, $default)
    {
        return isset($center) ? ($center == "true") : $default;
    }
}
