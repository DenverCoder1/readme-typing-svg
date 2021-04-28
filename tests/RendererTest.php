<?php declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class RendererTest extends TestCase
{

    protected static $font_db;

    public static function setUpBeforeClass(): void
    {
        self::$font_db = new DatabaseConnection();
    }

    /**
     * Test normal card render
     */
    public function testCardRender(): void
    {
        $params = array(
            "lines" => implode(";", array(
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            )),
            "center" => "true",
            "width" => "380",
            "height" => "50",
        );
        try {
            // create renderer model
            $model = new RendererModel("src/templates/main.php", $params, self::$font_db);
            $view = new RendererView($model);
        } catch (InvalidArgumentException $error) {
            // create error rendering model
            $model = new ErrorModel("src/templates/error.php", $error->getMessage());
            $view = new ErrorView($model);
        }
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $view->render());
    }

    /**
     * Test error card render
     */
    public function testErrorCardRender(): void
    {
        // missing lines
        $params = array(
            "center" => "true",
            "width" => "380",
            "height" => "50",
        );
        try {
            // create renderer model
            $model = new RendererModel("src/templates/main.php", $params, self::$font_db);
            $view = new RendererView($model);
        } catch (InvalidArgumentException $error) {
            // create error rendering model
            $model = new ErrorModel("src/templates/error.php", $error->getMessage());
            $view = new ErrorView($model);
        }
        $this->assertEquals(file_get_contents("tests/svg/test_missing_lines.svg"), $view->render());
    }

    /**
     * Test loading a valid Google Font
     */
    public function testLoadingGoogleFont(): void
    {
        $params = array(
            "lines" => "text",
            "font" => "Roboto",
        );
        try {
            // create renderer model
            $model = new RendererModel("src/templates/main.php", $params, self::$font_db);
            $view = new RendererView($model);
        } catch (InvalidArgumentException $error) {
            // create error rendering model
            $model = new ErrorModel("src/templates/error.php", $error->getMessage());
            $view = new ErrorView($model);
        }
        $expected = preg_replace("/\/\*(.*?)\*\//", "", file_get_contents("tests/svg/test_fonts.svg"));
        $actual = preg_replace("/\/\*(.*?)\*\//", "", $view->render());
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test loading a valid Google Font
     */
    public function testInvalidGoogleFont(): void
    {
        $params = array(
            "lines" => implode(";", array(
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            )),
            "center" => "true",
            "width" => "380",
            "font" => "Not-A-Font",
        );
        try {
            // create renderer model
            $model = new RendererModel("src/templates/main.php", $params, self::$font_db);
            $view = new RendererView($model);
        } catch (InvalidArgumentException $error) {
            // create error rendering model
            $model = new ErrorModel("src/templates/error.php", $error->getMessage());
            $view = new ErrorView($model);
        }
        $expected = str_replace('"monospace"', '"Not-A-Font"', file_get_contents("tests/svg/test_normal.svg"));
        $this->assertEquals($expected, $view->render());
    }
}
