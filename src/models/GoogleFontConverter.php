<?php

/**
 * Class for converting Google Fonts to base 64 for displaying through SVG image
 */
class GoogleFontConverter
{
    /**
     * Fetch CSS from Google Fonts
     *
     * @param string $font Google Font to fetch
     * @return string|false The CSS for displaying the font
     */
    public static function fetchFontCSS($font)
    {
        $url = "https://fonts.googleapis.com/css2?family=" . str_replace(" ", "+", $font);
        try {
            // get the CSS for the font
            $response = self::curl_get_contents($url);
            // find all font files and convert them to base64 Data URIs
            return self::encodeFonts($response);
        } catch (InvalidArgumentException $error) {
            return "";
        }
    }

    /**
     * Encode font urls in string as base 64
     *
     * @param string $css The CSS from Google Fonts
     * @return string CSS with urls replaced with base 64 Data URIs
     */
    private static function encodeFonts($css)
    {
        $urlRegex = '/\((https\:\/\/fonts\.gstatic\.com.+?)\) format\(\'(.*?)\'\)/';
        preg_match_all($urlRegex, $css, $matches);
        $urls = array_combine($matches[1], $matches[2]);
        // go over all links and replace with data URI
        foreach ($urls as $url => $fontType) {
            $response = self::curl_get_contents($url);
            $dataURI = "data:font/{$fontType};base64," . base64_encode($response);
            $css = str_replace($url, $dataURI, $css);
        }
        return $css;
    }

    /**
     * Get the contents of a URL
     *
     * @param string $url The URL to fetch
     * @return string Response from URL
     */
    private static function curl_get_contents($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode != 200) {
            throw new InvalidArgumentException("Failed to fetch Google Font from API.");
        }
        return $response;
    }
}
