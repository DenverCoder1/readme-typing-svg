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
     * Test per-line delays in normal mode without changing duration or pause.
     */
    public function testPerLineDelays(): void
    {
        $controller = new RendererController([
            "lines" => "line1;line2;line3",
            "delay" => "0;500;1000",
            "duration" => "1000",
            "pause" => "2000",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("begin='0s;d2.end'", $svg);
        $this->assertStringContainsString("begin='d0.end+500ms'", $svg);
        $this->assertStringContainsString("begin='d1.end+1000ms'", $svg);
        $this->assertSame(3, substr_count($svg, "dur='3000ms'"));
    }

    /**
     * Test a single delay value applies before the first line and each repeat.
     */
    public function testInitialAndRepeatDelay(): void
    {
        $controller = new RendererController([
            "lines" => "line1;line2",
            "delay" => "500",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("begin='500ms;d1.end+500ms'", $svg);
        $this->assertStringContainsString("begin='d0.end+500ms'", $svg);
    }

    /**
     * Test multiline delays include all preceding line delays in each timeline.
     */
    public function testMultilineDelays(): void
    {
        $controller = new RendererController([
            "lines" => "line1;line2;line3",
            "multiline" => "true",
            "delay" => "100;200;300",
            "duration" => "1000",
            "pause" => "500",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("dur='1600ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.0625;0.6875;1'", $svg);
        $this->assertStringContainsString("dur='3300ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.54545454545455;0.84848484848485;1'", $svg);
        $this->assertStringContainsString("dur='5100ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.70588235294118;0.90196078431373;1'", $svg);
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
     * Test delays inside grouped mode are included in group timing.
     */
    public function testGroupedLinesDelays(): void
    {
        $controller = new RendererController([
            "lines" => "line1;line2;line3",
            "groups" => "2,1",
            "delay" => "100;200;300",
            "duration" => "1000",
            "pause" => "500",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("dur='2800ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.035714285714286;0.32142857142857;0.92857142857143;1'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.46428571428571;0.75;0.92857142857143;1'", $svg);
        $this->assertStringContainsString("begin='d1.end'", $svg);
        $this->assertStringContainsString("dur='1800ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.16666666666667;0.61111111111111;0.88888888888889;1'", $svg);
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
        // Seed the RNG so shuffle() is deterministic (this seed reorders the groups to c,d,a,b).
        mt_srand(2);
        $params = [
            "lines" => "a;b;c;d",
            "groups" => "2,2",
            "random" => "true",
        ];
        $controller = new RendererController($params);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        // Grouped animation must still be used
        $this->assertStringContainsString("Grouped lines", $svg);

        // Read back the rendered line order
        preg_match_all("#> ([abcd]) </textPath>#", $svg, $matches);
        $order = $matches[1];
        $this->assertEqualsCanonicalizing(["a", "b", "c", "d"], $order, "All lines must survive the shuffle");

        // Groups [a,b] and [c,d] must each stay together in original intra-group order;
        // shuffling whole groups must never interleave their members.
        $posA = array_search("a", $order);
        $posC = array_search("c", $order);
        $this->assertSame("b", $order[$posA + 1], "Group [a,b] was split apart by the shuffle");
        $this->assertSame("d", $order[$posC + 1], "Group [c,d] was split apart by the shuffle");
    }

    /**
     * Test random mode keeps each delay attached to its line.
     */
    public function testRandomKeepsDelaysWithLines(): void
    {
        mt_srand(2);
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c;d",
            "delay" => "10;20;30;40",
            "random" => "true",
        ]);

        $delaysByLine = array_combine($model->lines, $model->delay);
        $this->assertEquals(["a" => 10, "b" => 20, "c" => 30, "d" => 40], $delaysByLine);
    }

    /**
     * Test per-line widths: each path ends at its own width and the SVG is as wide as the widest line.
     */
    public function testPerLineWidths(): void
    {
        $controller = new RendererController([
            "lines" => "Hi;Hello world",
            "width" => "40;300",
            "height" => "50",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        $this->assertStringContainsString("viewBox='0 0 300 50'", $svg);
        $this->assertStringContainsString("width='300px'", $svg);
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h40 ; m0,25 h40 ; m0,25 h0'", $svg);
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h300 ; m0,25 h300 ; m0,25 h0'", $svg);
    }

    /**
     * Test centered per-line widths start each path so the line stays centered.
     */
    public function testCenteredPerLineWidths(): void
    {
        $controller = new RendererController([
            "lines" => "Hi;Hello world",
            "width" => "40;300",
            "height" => "50",
            "center" => "true",
        ]);
        $svg = preg_replace("/\s+/", " ", $controller->render());

        // the 40px line starts (300 - 40) / 2 = 130px in, its text is centered 20px along its path
        $this->assertStringContainsString("values='m130,25 h0 ; m130,25 h40 ; m130,25 h40 ; m130,25 h0'", $svg);
        $this->assertStringContainsString("x='20' text-anchor='middle'", $svg);
        // the widest line keeps the original full-width path and 50% anchor
        $this->assertStringContainsString("values='m0,25 h0 ; m0,25 h300 ; m0,25 h300 ; m0,25 h0'", $svg);
        $this->assertStringContainsString("x='50%' text-anchor='middle'", $svg);
    }

    /**
     * Test per-line widths in multiline and grouped modes.
     */
    public function testPerLineWidthsMultilineAndGroups(): void
    {
        $multiline = new RendererController([
            "lines" => "a;bbbbbb",
            "width" => "50;200",
            "size" => "20",
            "multiline" => "true",
        ]);
        $svg = preg_replace("/\s+/", " ", $multiline->render());
        $this->assertStringContainsString("m0,25 h50", $svg);
        $this->assertStringContainsString("m0,50 h200", $svg);

        $grouped = new RendererController([
            "lines" => "a;bbbbbb;cc",
            "width" => "50;200;80",
            "size" => "20",
            "groups" => "2,1",
        ]);
        $svg = preg_replace("/\s+/", " ", $grouped->render());
        $this->assertStringContainsString("m0,25 h50", $svg);
        $this->assertStringContainsString("m0,50 h200", $svg);
        $this->assertStringContainsString("m0,25 h80", $svg);
    }

    /**
     * Test random mode keeps each width attached to its line.
     */
    public function testRandomKeepsWidthsWithLines(): void
    {
        mt_srand(2);
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c;d",
            "width" => "10;20;30;40",
            "random" => "true",
        ]);

        $widthsByLine = array_combine($model->lines, $model->lineWidths);
        $this->assertEquals(["a" => 10, "b" => 20, "c" => 30, "d" => 40], $widthsByLine);
    }

    /**
     * Test widthSpeed keeps typing speed constant: the narrow line finishes typing sooner
     */
    public function testWidthSpeedShortensNarrowLine(): void
    {
        $params = [
            "lines" => "Hi;Hello world",
            "width" => "40;300",
            "height" => "50",
            "duration" => "1000",
            "pause" => "0",
        ];
        $fixed = preg_replace("/\\s+/", " ", (new RendererController($params))->render());
        $scaled = preg_replace("/\\s+/", " ", (new RendererController($params + ["widthSpeed" => "true"]))->render());

        // off: both lines take the full duration
        $this->assertStringContainsString("dur='1000ms'", $fixed);
        // on: the 40px line takes 1000 * 40 / 300 = 133ms, the widest keeps 1000ms
        $this->assertStringContainsString("dur='133ms'", $scaled);
        $this->assertStringContainsString("dur='1000ms'", $scaled);
    }

    /**
     * Test widthSpeed with a uniform width renders byte for byte the same SVG as before
     */
    public function testWidthSpeedNoOpWhenWidthIsUniform(): void
    {
        $base = [
            "lines" => "first;second;third",
            "width" => "400",
            "duration" => "1000",
            "pause" => "500",
            "delay" => "100;200;300",
        ];
        foreach ([
            "single" => [],
            "multiline" => ["multiline" => "true"],
            "groups" => ["groups" => "2,1"],
        ] as $mode => $extra) {
            $off = preg_replace("/\\s+/", " ", (new RendererController($base + $extra))->render());
            $on = preg_replace("/\\s+/", " ", (new RendererController($base + $extra + ["widthSpeed" => "true"]))->render());
            $this->assertSame($off, $on, "widthSpeed changed output in $mode mode with a single width");
        }
    }

    /**
     * Test widthSpeed in multiline mode advances each line by the previous line's typing time
     */
    public function testWidthSpeedMultiline(): void
    {
        $params = [
            "lines" => "a;bbbbbb",
            "width" => "50;200",
            "size" => "20",
            "multiline" => "true",
            "duration" => "1000",
            "pause" => "0",
        ];
        $svg = preg_replace("/\\s+/", " ", (new RendererController($params + ["widthSpeed" => "true"]))->render());

        // line 1 types for 250ms then hands over; line 2 keeps the full 1000ms
        $this->assertStringContainsString("dur='1250ms'", $svg);
        $this->assertStringContainsString("keyTimes='0;0.2;1;1'", $svg);
    }

    /**
     * Test widthSpeed in grouped mode keeps pauses and the group cadence intact
     */
    public function testWidthSpeedGroups(): void
    {
        $params = [
            "lines" => "a;bbbbbb;cc",
            "width" => "50;200;80",
            "size" => "20",
            "groups" => "2,1",
            "duration" => "1000",
            "pause" => "500",
        ];
        $svg = preg_replace("/\\s+/", " ", (new RendererController($params + ["widthSpeed" => "true"]))->render());

        // group 0 types 250 (50px) + 1000 (200px) = 1250ms, plus the 500ms pause
        $this->assertStringContainsString("dur='1750ms'", $svg);
        // group 1 types 400ms (80px) then pauses 500ms
        $this->assertStringContainsString("dur='900ms'", $svg);
        // every keyTime stays inside [0, 1] and never goes backwards
        foreach (["0;0;0.11428571428571;0.88571428571429;1", "0;0.14285714285714;0.6;0.88571428571429;1", "0;0;0.35555555555556;0.91111111111111;1"] as $expected) {
            $this->assertStringContainsString("keyTimes='$expected'", $svg);
        }
    }

    /**
     * Test random mode keeps each type duration with its line
     */
    public function testRandomKeepsTypeDurationsWithLines(): void
    {
        mt_srand(7);
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c;d",
            "width" => "10;20;30;40",
            "duration" => "1000",
            "widthSpeed" => "true",
            "random" => "true",
        ]);
        $byLine = array_combine($model->lines, $model->typeDurations);
        $this->assertEquals(["a" => 250.0, "b" => 500.0, "c" => 750.0, "d" => 1000.0], $byLine);
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
