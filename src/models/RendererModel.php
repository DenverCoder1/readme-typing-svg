<?php declare (strict_types = 1);

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

    /** @var int $size Font size */
    public $size;

    /** @var bool $center Whether or not to center text */
    public $center;

    /** @var int $width SVG width (px) */
    public $width;

    /** @var int $height SVG height (px) */
    public $height;

    /** @var bool $multiline True = wrap to new lines, False = retype on same line */
    public $multiline;

    /** @var string $fontCSS CSS required for displaying the selected font */
    public $fontCSS;

    /** @var string $template Path to template file */
    public $template;

    /** @var DatabaseConnection $database Database connection */
    private $database;

    /** @var array<string, string> $DEFAULTS */
    private $DEFAULTS = array(
        "font" => "monospace",
        "color" => "#36BCF7",
        "size" => "20",
        "center" => "false",
        "width" => "400",
        "height" => "50",
        "multiline" => "false",
    );

    /**
     * Construct RendererModel
     *
     * @param string $template Path to the template file
     * @param array<string, string> $params request parameters
     * @param DatabaseConnection $font_db Database connection
     */
    public function __construct($template, $params, $database)
    {
        $this->template = $template;
        $this->database = $database;
        $this->lines = $this->checkLines($params["lines"] ?? "");
        $this->font = $this->checkFont($params["font"] ?? $this->DEFAULTS["font"]);
        $this->color = $this->checkColor($params["color"] ?? $this->DEFAULTS["color"]);
        $this->size = $this->checkNumber($params["size"] ?? $this->DEFAULTS["size"], "Font size");
        $this->center = $this->checkBoolean($params["center"] ?? $this->DEFAULTS["center"]);
        $this->width = $this->checkNumber($params["width"] ?? $this->DEFAULTS["width"], "Width");
        $this->height = $this->checkNumber($params["height"] ?? $this->DEFAULTS["height"], "Height");
        $this->multiline = $this->checkBoolean($params["multiline"] ?? $this->DEFAULTS["multiline"]);
        $this->fontCSS = $this->fetchFontCSS($this->font);
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
        $exploded = explode(";", $lines);
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
     * @return string Sanitized color with preceding hash symbol
     */
    private function checkColor($color)
    {
        $sanitized = (string) preg_replace("/[^0-9A-Fa-f]/", "", $color);
        // if color is not a valid length, use the default
        if (!in_array(strlen($sanitized), [3, 4, 6, 8])) {
            return $this->DEFAULTS["color"];
        }
        // return sanitized color
        return "#" . $sanitized;
    }

    /**
     * Validate numeric parameter and return valid integer
     *
     * @param string $num Parameter to validate
     * @param string $field Field name for displaying in case of error
     * @return int Sanitized digits and int
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
     * Fetch CSS with Base-64 encoding from database or store new entry if it is missing
     *
     * @param string $font Google Font to fetch
     * @return string The CSS for displaying the font
     */
    private function fetchFontCSS($font)
    {
        // skip checking if left as default
        if ($font != $this->DEFAULTS["font"]) {
            // fetch from database
            $from_database = $this->database->fetchFontCSS($font);
            if ($from_database) {
                // return the CSS for displaying the font
                $date = $from_database[0];
                $css = $from_database[1];
                return "<style>\n/* From database {$date} */\n{$css}</style>\n";
            }
            // fetch and convert from Google Fonts if not found in database
            $from_google_fonts = GoogleFontConverter::fetchFontCSS($font);
            if ($from_google_fonts) {
                // add font to the database
                $this->database->insertFontCSS($font, $from_google_fonts);
                // return the CSS for displaying the font
                $date = date('Y-m-d');
                return "<style>\n/* From Google Fonts {$date} */\n{$from_google_fonts}</style>\n";
            }
        }
        // font is not in database or Google Fonts
        return "";
    }
}
