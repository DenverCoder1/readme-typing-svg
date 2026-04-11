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
            $controller->render(),
        );
        $this->assertStringContainsString("keyTimes='0;0.5;1;1'", $controller->render());
        $this->assertStringContainsString(
            "values='m0,50 h0 ; m0,50 h0 ; m0,50 h380 ; m0,50 h380'",
            $controller->render(),
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
                $controller->render(),
            ),
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
            $actualSVG,
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

    /**
     * Test separator set to something other than ";"
     */
    public function testSeparator(): void
    {
        $params = [
            "lines" => implode(";;", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "center" => "true",
            "vCenter" => "true",
            "width" => "380",
            "height" => "50",
            "separator" => ";;",
        ];
        $controller = new RendererController($params);
        $expectedSVG = file_get_contents("tests/svg/test_normal.svg");
        $actualSVG = $controller->render();
        $this->compareNoCommentsOrWhitespace($expectedSVG, $actualSVG);
    }

    /**
     * Test random
     */
    public function testRandom(): void
    {
        $lines = [
            "Full-stack web and app developer",
            "Self-taught UI/UX Designer",
            "10+ years of coding experience",
            "Always learning new things",
        ];
        $params = [
            "lines" => implode(";", $lines),
            "random" => "true",
        ];
        $controller = new RendererController($params);
        $actualSVG = preg_replace("/\s+/", " ", $controller->render());
        foreach ($lines as $line) {
            $this->assertStringContainsString("> $line </textPath>", $actualSVG);
        }
    }

    /**
     * Test grouped lines animation: 3 lines with groups=2,1
     * Group 0 (lines 0,1): both lines type sequentially and clear together.
     * Group 1 (line 2): behaves like a single-line cycle.
     */
    public function testGroupedLinesRender(): void
    {
        $params = [
            "lines" => "line1;line2;line3",
            "groups" => "2,1",
            "width" => "400",
            "height" => "75",
            "duration" => "5000",
            "pause" => "0",
        ];
        $controller = new RendererController($params);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        // Group 0, line 0 (p=0, k=2, groupDuration=10000): begins at 0s, types first
        $this->assertStringContainsString("begin='0s;d2.end'", $svg);
        $this->assertStringContainsString("dur='10000ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0;0.4;0.9;1'", $svg);
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h0 ; m0,25 h400 ; m0,25 h400 ; m0,25 h0'", $svg);

        // Group 0, line 1 (p=1, k=2, groupDuration=10000): same begin, waits for line 0
        $this->assertStringContainsString("keyTimes='0;0.5;0.9;0.9;1'", $svg);
        $this->assertStringContainsString("values='m0,50 h0 ; m0,50 h0 ; m0,50 h400 ; m0,50 h400 ; m0,50 h0'", $svg);

        // Group 1, line 2 (k=1, groupDuration=5000): begins after group 0 ends
        $this->assertStringContainsString("begin='d1.end'", $svg);
        $this->assertStringContainsString("dur='5000ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0;0.8;0.8;1'", $svg);
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h0 ; m0,25 h400 ; m0,25 h400 ; m0,25 h0'", $svg);
    }

    /**
     * Test grouped lines with pause: pause applied once per group at the end
     * groupDuration = k*duration + pause = 2*5000 + 1000 = 11000
     */
    public function testGroupedLinesPause(): void
    {
        $params = [
            "lines" => "line1;line2",
            "groups" => "2",
            "width" => "400",
            "height" => "60",
            "duration" => "5000",
            "pause" => "1000",
        ];
        $controller = new RendererController($params);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("dur='11000ms'", $svg);
        // Both lines share the same begin and dur, so both clear at the same moment
        $this->assertEquals(2, substr_count($svg, "dur='11000ms'"));
    }

    /**
     * Test grouped lines with repeat=false: last group stays visible
     */
    public function testGroupedLinesRepeatFalse(): void
    {
        $params = [
            "lines" => "line1;line2",
            "groups" => "1,1",
            "width" => "400",
            "height" => "50",
            "duration" => "5000",
            "pause" => "0",
            "repeat" => "false",
        ];
        $controller = new RendererController($params);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        // First group: begin at 0s with no repeat trigger
        $this->assertStringContainsString("begin='0s'", $svg);
        $this->assertStringNotContainsString(";d1.end", $svg);

        // Last line should freeze (fill='freeze', last value is fullLine not emptyLine)
        $this->assertStringContainsString("fill='freeze'", $svg);
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h0 ; m0,25 h400 ; m0,25 h400 ; m0,25 h400'", $svg);
    }

    /**
     * Test random + groups: lines within each group must stay together
     */
    public function testRandomWithGroups(): void
    {
        $params = [
            "lines" => "a;b;c;d",
            "groups" => "2,2",
            "random" => "true",
        ];
        $controller = new RendererController($params);
        $svg = preg_replace("/\s+/", " ", $controller->render());
        // All lines should still be present
        $this->assertStringContainsString("> a </textPath>", $svg);
        $this->assertStringContainsString("> b </textPath>", $svg);
        $this->assertStringContainsString("> c </textPath>", $svg);
        $this->assertStringContainsString("> d </textPath>", $svg);
        // Lines within each group share the same dur, so groups stay as units
        // Both groups have size 2 with same timing, verify grouped animation is used
        $this->assertStringContainsString("Grouped lines", $svg);
    }

    /**
     * Test Letter Spacing
     */
    public function testLetterSpacing()
    {
        $params = [
            "lines" => implode(";", [
                "Full-stack web and app developer",
                "Self-taught UI/UX Designer",
                "10+ years of coding experience",
                "Always learning new things",
            ]),
            "letterSpacing" => "10px",
        ];
        $controller = new RendererController($params);
        $actualSVG = preg_replace("/\s+/", " ", $controller->render());
        $this->assertStringContainsString("letter-spacing='10px'", $actualSVG);
        $this->assertStringNotContainsString("letter-spacing='normal'", $actualSVG);
    }
}
