<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require "vendor/autoload.php";

final class RendererTest extends TestCase
{
    /**
     * Static method to assert strings are equal while ignoring whitespace
     *
     * @param string $expected
     * @param string $actual
     */
    public static function compareNoCommentsOrWhitespace(string $expected, string $actual)
    {
        // remove comments and whitespace
        $expected = preg_replace("/\s+/", " ", preg_replace("/<!--.*?-->/s", " ", $expected));
        $actual = preg_replace("/\s+/", " ", preg_replace("/<!--.*?-->/s", " ", $actual));
        // add newlines to make it easier to debug
        $expected = str_replace(">", ">\n", $expected);
        $actual = str_replace(">", ">\n", $actual);
        // assert strings are equal
        self::assertSame($expected, $actual);
    }

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
        $expectedSVG = file_get_contents("tests/svg/test_normal.svg");
        $actualSVG = $controller->render();
        $this->compareNoCommentsOrWhitespace($expectedSVG, $actualSVG);
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
        $this->assertStringContainsString("keyTimes='0;0;1;1'", $controller->render());
        $this->assertStringContainsString(
            "values='m0,25 h0 ; m0,25 h0 ; m0,25 h380 ; m0,25 h380'",
            $controller->render()
        );
        $this->assertStringContainsString("keyTimes='0;0.5;1;1'", $controller->render());
        $this->assertStringContainsString(
            "values='m0,50 h0 ; m0,50 h0 ; m0,50 h380 ; m0,50 h380'",
            $controller->render()
        );
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
        $this->assertStringContainsString("Lines parameter must be set.", $controller->render());
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
        $this->assertStringContainsString("@font-face {", $controller->render());
        $this->assertSame(
            1,
            preg_match(
                "/src: url\(data:font\/truetype;base64,[a-zA-Z0-9\/+=]+\) format\('truetype'\);/",
                $controller->render()
            )
        );
        $this->assertStringContainsString("font-family='\"Roboto\", monospace'", $controller->render());
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
        $this->assertStringContainsString("font-family='\"Not-A-Font\", monospace'", $controller->render());
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
        $expectedSVG = file_get_contents("tests/svg/test_normal.svg");
        $actualSVG = $controller->render();
        $this->compareNoCommentsOrWhitespace($expectedSVG, $actualSVG);
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
        $this->assertStringContainsString("dominant-baseline='auto'", $controller->render());
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
        $this->assertStringContainsString("dur='6000ms'", $controller->render());
        $this->assertStringContainsString("keyTimes='0;0.66666666666667;0.83333333333333;1'", $controller->render());
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
        $this->assertStringContainsString("dur='6000ms'", $controller->render());
        $this->assertStringContainsString("keyTimes='0;0;0.83333333333333;1'", $controller->render());
        $this->assertStringContainsString("dur='12000ms'", $controller->render());
        $this->assertStringContainsString("keyTimes='0;0.5;0.91666666666667;1'", $controller->render());
    }

    /**
     * Test repeat set to false
     */
    public function testRepeatFalse(): void
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
            "repeat" => "false",
        ];
        $controller = new RendererController($params);
        $actualSVG = preg_replace("/\s+/", " ", $controller->render());
        $this->assertStringContainsString("begin='0s'", $actualSVG);
        $this->assertStringContainsString(
            "begin='d2.end' dur='5000ms' fill='freeze' values='m0,25 h0 ; m0,25 h380 ; m0,25 h380 ; m0,25 h380'",
            $actualSVG
        );
        $this->assertStringNotContainsString(";d3.end", $actualSVG);
    }

    /**
     * Test repeat set to false on multiline card
     */
    public function testRepeatFalseMultiline(): void
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
            "repeat" => "false",
        ];
        $controller = new RendererController($params);
        $actualSVG = preg_replace("/\s+/", " ", $controller->render());
        $this->assertStringContainsString("begin='0s'", $actualSVG);
        $this->assertStringNotContainsString(";d3.end", $actualSVG);
    }
}
