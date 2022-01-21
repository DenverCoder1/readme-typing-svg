<?php declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class RendererTest extends TestCase
{

    protected static $database;

    public static function setUpBeforeClass(): void
    {
        self::$database = new DatabaseConnection();
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
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        );
        $controller = new RendererController($params, self::$database);
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $controller->render());
    }

    public function testMultilineCardRender(): void
    {
        $params = array(
            "lines" => implode(";", array(
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            )),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "200",
            "multiline" => "true",
        );
        $controller = new RendererController($params, self::$database);
        $this->assertEquals(file_get_contents("tests/svg/test_multiline.svg"), $controller->render());
    }

    /**
     * Test error card render
     */
    public function testErrorCardRender(): void
    {
        // missing lines
        $params = array(
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        );
        $controller = new RendererController($params, self::$database);
        $this->assertEquals(file_get_contents("tests/svg/test_missing_lines.svg"), $controller->render());
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
        $controller = new RendererController($params, self::$database);
        $expected = preg_replace("/\/\*(.*?)\*\//", "", file_get_contents("tests/svg/test_fonts.svg"));
        $actual = preg_replace("/\/\*(.*?)\*\//", "", $controller->render());
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
            "vCenter" => "true",
            "width" => "380",
            "font" => "Not-A-Font",
        );
        $controller = new RendererController($params, self::$database);
        $expected = str_replace('"monospace"', '"Not-A-Font"', file_get_contents("tests/svg/test_normal.svg"));
        $this->assertEquals($expected, $controller->render());
    }
    
    /**
     * Test if a trailing ";" in lines is trimmed; see issue #25
     */
    public function testLineTrimming(): void
    {
        $params = array(
            "lines" => implode(";", array(
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
                "",
            )),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        );
        $controller = new RendererController($params, self::$database);
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $controller->render());
    }
    
    /**
     * Test normal vertical alignment
     */
    public function testNormalVerticalAlignment(): void
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
        $controller = new RendererController($params, self::$database);
        $this->assertEquals(file_get_contents("tests/svg/test_normal_vertical_alignment.svg"), $controller->render());
    }
}
