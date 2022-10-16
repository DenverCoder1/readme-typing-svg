<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require "vendor/autoload.php";

final class RendererTest extends TestCase
{
    /**
     * Test normal card render
     */
    public function testCardRender(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $controller->render());
    }

    public function testMultilineCardRender(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "200",
            "multiline" => "true",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_multiline.svg"), $controller->render());
    }

    /**
     * Test error card render
     */
    public function testErrorCardRender(): void
    {
        // missing lines
        $params = [
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_missing_lines.svg"), $controller->render());
    }

    /**
     * Test loading a valid Google Font
     */
    public function testLoadingGoogleFont(): void
    {
        $params = [
            "lines" => "text",
            "font" => "Roboto",
        ];
        $controller = new RendererController($params);
        $expected = preg_replace("/\/\*(.*?)\*\//", "", file_get_contents("tests/svg/test_fonts.svg"));
        $actual = preg_replace("/\/\*(.*?)\*\//", "", $controller->render());
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test loading a valid Google Font
     */
    public function testInvalidGoogleFont(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "font" => "Not-A-Font",
        ];
        $controller = new RendererController($params);
        $expected = str_replace('"monospace"', '"Not-A-Font"', file_get_contents("tests/svg/test_normal.svg"));
        $this->assertEquals($expected, $controller->render());
    }

    /**
     * Test if a trailing ";" in lines is trimmed; see issue #25
     */
    public function testLineTrimming(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
                "",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $controller->render());
    }

    /**
     * Test normal vertical alignment
     */
    public function testNormalVerticalAlignment(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "width" => "380",
            "height" => "50",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_normal_vertical_alignment.svg"), $controller->render());
    }

    /**
     * Test pause parameter
     */
    public function testPauseParameter(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
            "pause" => "1000",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_pause.svg"), $controller->render());
    }

    /**
     * Test pause on multiline card
     */
    public function testPauseMultiline(): void
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "200",
            "multiline" => "true",
            "pause" => "1000",
        ];
        $controller = new RendererController($params);
        $this->assertEquals(file_get_contents("tests/svg/test_pause_multiline.svg"), $controller->render());
    }
}
