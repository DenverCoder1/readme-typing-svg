<?php

declare(strict_types=1);

/**
 * Model for SVG outputs
 */
class RendererModel
{
    /** @var array<string> $lines text to display */
    public $lines;

    /** @var string $font Font family */
    public $font;

    /** @var string $color Font color */
    public $color;

    /** @var string $background Background color */
    public $background;

    /** @var int $size Font size */
    public $size;

    /** @var bool $center Whether or not to center text horizontally */
    public $center;

    /** @var bool $vCenter Whether or not to center text vertically */
    public $vCenter;

    /** @var int $width SVG width (px) */
    public $width;

    /** @var int $height SVG height (px) */
    public $height;

    /** @var bool $multiline True = wrap to new lines, False = retype on same line */
    public $multiline;

    /** @var int $duration print duration in milliseconds */
    public $duration;

    /** @var int $pause pause duration between lines in milliseconds */
    public $pause;

    /** @var string $fontCSS CSS required for displaying the selected font */
    public $fontCSS;

    /** @var string $template Path to template file */
    public $template;

    /** @var array<string, string> $DEFAULTS */
    private $DEFAULTS = array(
        "font" => "monospace",
        "color" => "#36BCF7",
        "background" => "#00000000",
        "size" => "20",
        "center" => "false",
        "vCenter" => "false",
        "width" => "400",
        "height" => "50",
        "multiline" => "false",
        "duration" => "5000",
        "pause" => "0",
    );

    /**
     * Construct RendererModel
     *
     * @param string $template Path to the template file
     * @param array<string, string> $params request parameters
     */
    public function __construct($template, $params)
    {
        $this->template = $template;
        $this->lines = $this->checkLines($params["lines"] ?? "");
        $this->font = $this->checkFont($params["font"] ?? $this->DEFAULTS["font"]);
        $this->color = $this->checkColor($params["color"] ?? $this->DEFAULTS["color"], "color");
        $this->background = $this->checkColor($params["background"] ?? $this->DEFAULTS["background"], "background");
        $this->size = $this->checkNumberPositive($params["size"] ?? $this->DEFAULTS["size"], "Font size");
        $this->center = $this->checkBoolean($params["center"] ?? $this->DEFAULTS["center"]);
        $this->vCenter = $this->checkBoolean($params["vCenter"] ?? $this->DEFAULTS["vCenter"]);
        $this->width = $this->checkNumberPositive($params["width"] ?? $this->DEFAULTS["width"], "Width");
        $this->height = $this->checkNumberPositive($params["height"] ?? $this->DEFAULTS["height"], "Height");
        $this->multiline = $this->checkBoolean($params["multiline"] ?? $this->DEFAULTS["multiline"]);
        $this->duration = $this->checkNumberPositive($params["duration"] ?? $this->DEFAULTS["duration"], "duration");
        $this->pause = $this->checkNumberNonNegative($params["pause"] ?? $this->DEFAULTS["pause"], "pause");
        $this->fontCSS = $this->fetchFontCSS($this->font, $params["lines"]);
    }

    /**
     * Validate lines and return array of string
     *
     * @param string $lines Semicolon-separated lines parameter
     * @return array<string> escaped array of lines
     */
    private function checkLines($lines)
    {
        if (!$lines) {
            throw new InvalidArgumentException("Lines parameter must be set.");
        }
        $trimmed_lines = rtrim($lines, ';');
        $exploded = explode(";", $trimmed_lines);
        // escape special characters to prevent code injection
        return array_map("htmlspecialchars", $exploded);
    }

    /**
     * Validate font family and return valid string
     *
     * @param string $font Font name parameter
     * @return string Sanitized font name
     */
    private function checkFont($font)
    {
        // return sanitized font name
        return preg_replace("/[^0-9A-Za-z\- ]/", "", $font);
    }

    /**
     * Validate font color and return valid string
     *
     * @param string $color Color parameter
     * @param string $field Field name for displaying in case of error
     * @return string Sanitized color with preceding hash symbol
     */
    private function checkColor($color, $field)
    {
        $sanitized = (string) preg_replace("/[^0-9A-Fa-f]/", "", $color);
        // if color is not a valid length, use the default
        if (!in_array(strlen($sanitized), [3, 4, 6, 8])) {
            return $this->DEFAULTS[$field];
        }
        // return sanitized color
        return "#" . $sanitized;
    }

    /**
     * Validate positive numeric parameter and return valid integer
     *
     * @param string $num Parameter to validate
     * @param string $field Field name for displaying in case of error
     * @return int Sanitized digits and int
     */
    private function checkNumberPositive($num, $field)
    {
        $digits = intval(preg_replace("/[^0-9\-]/", "", $num));
        if ($digits <= 0) {
            throw new InvalidArgumentException("$field must be a positive number.");
        }
        return $digits;
    }

    /**
     * Validate non-negative numeric parameter and return valid integer
     *
     * @param string $num Parameter to validate
     * @param string $field Field name for displaying in case of error
     * @return int Sanitized digits and int
     */
    private function checkNumberNonNegative($num, $field)
    {
        $digits = intval(preg_replace("/[^0-9\-]/", "", $num));
        if ($digits < 0) {
            throw new InvalidArgumentException("$field must be a non-negative number.");
        }
        return $digits;
    }

    /**
     * Validate "true" or "false" value as string and return boolean
     *
     * @param string $bool Boolean parameter as string
     * @return boolean Whether or not $bool is set to "true"
     */
    private function checkBoolean($bool)
    {
        return strtolower($bool) == "true";
    }

    /**
     * Fetch CSS with Base-64 encoding from Google Fonts
     *
     * @param string $font Google Font to fetch
     * @param string $text Text to display in font
     * @return string The CSS for displaying the font
     */
    private function fetchFontCSS($font, $text)
    {
        // skip checking if left as default
        if ($font != $this->DEFAULTS["font"]) {
            // fetch and convert from Google Fonts
            $from_google_fonts = GoogleFontConverter::fetchFontCSS($font, $text);
            if ($from_google_fonts) {
                // return the CSS for displaying the font
                return "<style>\n{$from_google_fonts}</style>\n";
            }
        }
        // font is not found
        return "";
    }
}
