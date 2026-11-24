<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require "vendor/autoload.php";

final class OptionsTest extends TestCase
{
    /**
     * Test exception thrown when missing 'lines' parameter
     */
    public function testMissingLines(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Lines parameter must be set.");
        $params = [
            "center" => "true",
            "width" => "380",
            "height" => "50",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test valid font
     */
    public function testValidFont(): void
    {
        $params = [
            "lines" => "text",
            "font" => "Open Sans",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("Open Sans", $model->font);
    }

    /**
     * Test valid font color
     */
    public function testValidFontColor(): void
    {
        $params = [
            "lines" => "text",
            "color" => "000000",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#000000", $model->color);
    }

    /**
     * Test invalid font color
     */
    public function testInvalidFontColor(): void
    {
        $params = [
            "lines" => "text",
            "color" => "00000",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#36BCF7", $model->color);
    }

    /**
     * Test valid background color
     */
    public function testValidBackgroundColor(): void
    {
        $params = [
            "lines" => "text",
            "background" => "00000033",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#00000033", $model->background);
    }

    /**
     * Test invalid background color
     */
    public function testInvalidBackgroundColor(): void
    {
        $params = [
            "lines" => "text",
            "background" => "00000",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#00000000", $model->background);
    }

    /**
     * Test valid font size
     */
    public function testValidFontSize(): void
    {
        $params = [
            "lines" => "text",
            "size" => "18",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(18, $model->size);
    }

    /**
     * Test exception thrown when font size is invalid
     */
    public function testInvalidFontSize(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Font size must be a positive number.");
        $params = [
            "lines" => "text",
            "size" => "0",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test valid height
     */
    public function testValidHeight(): void
    {
        $params = [
            "lines" => "text",
            "height" => "80",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(80, $model->height);
    }

    /**
     * Test exception thrown when height is invalid
     */
    public function testInvalidHeight(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Height must be a positive number.");
        $params = [
            "lines" => "text",
            "height" => "x",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test valid width
     */
    public function testValidWidth(): void
    {
        $params = [
            "lines" => "text",
            "width" => "500",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(500, $model->width);
    }

    /**
     * Test exception thrown when width is invalid
     */
    public function testInvalidWidth(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Width must be a positive number.");
        $params = [
            "lines" => "text",
            "width" => "-1",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test center set to true
     */
    public function testCenterIsTrue(): void
    {
        $params = [
            "lines" => "text",
            "center" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->center);
    }

    /**
     * Test center not set to true
     */
    public function testCenterIsNotTrue(): void
    {
        $params = [
            "lines" => "text",
            "center" => "other",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->center);
    }

    /**
     * Test vCenter set to true
     */
    public function testVCenterIsTrue(): void
    {
        $params = [
            "lines" => "text",
            "vCenter" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->vCenter);
    }

    /**
     * Test vCenter not set to true
     */
    public function testVCenterIsNotTrue(): void
    {
        $params = [
            "lines" => "text",
            "vCenter" => "other",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->vCenter);
    }

    /**
     * Test multiline set to true
     */
    public function testMultilineIsTrue(): void
    {
        $params = [
            "lines" => "text",
            "multiline" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->multiline);
    }

    /**
     * Test multiline not set to true
     */
    public function testMultilineIsNotTrue(): void
    {
        $params = [
            "lines" => "text",
            "multiline" => "false",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->multiline);
    }

    /**
     * Test valid duration
     */
    public function testValidDuration(): void
    {
        $params = [
            "lines" => "text",
            "duration" => "500",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(500, $model->duration);
    }

    /**
     * Test exception thrown when duration is invalid
     */
    public function testInvalidDuration(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("duration must be a positive number.");
        $params = [
            "lines" => "text",
            "duration" => "-1",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test valid pause
     */
    public function testValidPause(): void
    {
        $params = [
            "lines" => "text",
            "pause" => "500",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(500, $model->pause);
    }

    /**
     * Test valid pause at 0
     */
    public function testValidPauseZero(): void
    {
        $params = [
            "lines" => "text",
            "pause" => "0",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(0, $model->pause);
    }

    /**
     * Test exception thrown when pause is invalid
     */
    public function testInvalidPause(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("pause must be a non-negative number.");
        $params = [
            "lines" => "text",
            "pause" => "-1",
        ];
        print_r(new RendererModel("src/templates/main.php", $params));
    }

    /**
     * Test delay defaults to zero for every line
     */
    public function testDelayDefaultsToZero(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
        ]);
        $this->assertSame([0, 0, 0], $model->delay);
    }

    /**
     * Test one delay value applies to every line
     */
    public function testSingleDelayAppliesToEveryLine(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "delay" => "500",
        ]);
        $this->assertSame([500, 500, 500], $model->delay);
    }

    /**
     * Test semicolon-separated delay values are parsed per line
     */
    public function testPerLineDelays(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "delay" => "0;500;1000",
        ]);
        $this->assertSame([0, 500, 1000], $model->delay);
    }

    /**
     * Test malformed delay values are rejected
     */
    public function testInvalidDelay(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("delay must be a non-negative integer.");
        new RendererModel("src/templates/main.php", [
            "lines" => "text",
            "delay" => "-1",
        ]);
    }

    /**
     * Test non-numeric delay values are rejected
     */
    public function testNonNumericDelay(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("delay must be a non-negative integer.");
        new RendererModel("src/templates/main.php", [
            "lines" => "text",
            "delay" => "abc",
        ]);
    }

    /**
     * Test the number of per-line delays must match the number of lines
     */
    public function testDelayCountMustMatchLineCount(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("delay must contain either one value or one value per line.");
        new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "delay" => "100;200",
        ]);
    }

    /**
     * Test one width value applies to every line
     */
    public function testSingleWidthAppliesToEveryLine(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "width" => "300",
        ]);
        $this->assertSame([300, 300, 300], $model->lineWidths);
        $this->assertSame(300, $model->width);
    }

    /**
     * Test semicolon-separated width values are parsed per line and the SVG uses the widest
     */
    public function testPerLineWidths(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "width" => "120;450;200",
        ]);
        $this->assertSame([120, 450, 200], $model->lineWidths);
        $this->assertSame(450, $model->width);
    }

    /**
     * Test each per-line width must be positive
     */
    public function testInvalidPerLineWidth(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Width must be a positive number.");
        new RendererModel("src/templates/main.php", [
            "lines" => "a;b",
            "width" => "200;0",
        ]);
    }

    /**
     * Test the number of per-line widths must match the number of lines
     */
    public function testWidthCountMustMatchLineCount(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("width must contain either one value or one value per line.");
        new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "width" => "100;200",
        ]);
    }

    /**
     * Test repeat set to true, false, other
     */
    public function testRepeat(): void
    {
        // not set
        $params = [
            "lines" => "text",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->repeat);

        // true
        $params = [
            "lines" => "text",
            "repeat" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->repeat);

        // other / false
        $params = [
            "lines" => "text",
            "repeat" => "other",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->repeat);
    }

    /**
     * Test separator set to something other than ";"
     */
    public function testSeparator(): void
    {
        $params = [
            "lines" => "text;text2",
            "separator" => ";;",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(";;", $model->separator);
        $this->assertEquals(["text;text2"], $model->lines);

        $params = [
            "lines" => "text;;tex;t2",
            "separator" => ";;",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(";;", $model->separator);
        $this->assertEquals(["text", "tex;t2"], $model->lines);
    }

    /**
     * Test random order
     */
    public function testRandom(): void
    {
        // not set
        $params = [
            "lines" => "text",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->random);

        // true
        $params = [
            "lines" => "text",
            "random" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(true, $model->random);

        // other / false
        $params = [
            "lines" => "text",
            "random" => "other",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals(false, $model->random);
    }

    /**
     * Test valid groups parameter
     */
    public function testValidGroups(): void
    {
        $params = [
            "lines" => "a;b;c",
            "groups" => "2,1",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals([2, 1], $model->groups);
    }

    /**
     * Test groups not provided returns null
     */
    public function testGroupsNotProvided(): void
    {
        $params = [
            "lines" => "a;b;c",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertNull($model->groups);
    }

    /**
     * Test groups sum mismatch throws exception
     */
    public function testGroupsSumMismatch(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Sum of group sizes (3) must equal number of lines (2).");
        $params = [
            "lines" => "a;b",
            "groups" => "2,1",
        ];
        new RendererModel("src/templates/main.php", $params);
    }

    /**
     * Test groups with a zero size throws exception
     */
    public function testGroupsZeroSize(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Each group size must be a positive number.");
        $params = [
            "lines" => "a;b",
            "groups" => "0,2",
        ];
        new RendererModel("src/templates/main.php", $params);
    }

    /**
     * Test Letter Spacing
     */
    public function testLetterSpacing(): void
    {
        // default
        $params = [
            "lines" => "text",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("normal", $model->letterSpacing);

        // invalid
        $params = [
            "lines" => "text",
            "letterSpacing" => "invalid",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("normal", $model->letterSpacing);

        // valid
        $params = [
            "lines" => "text",
            "letterSpacing" => "10px",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("10px", $model->letterSpacing);
    }

    /**
     * Test widthSpeed is off by default and leaves every line at the full duration
     */
    public function testWidthSpeedIsOffByDefault(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b",
            "width" => "100;200",
            "duration" => "1000",
        ]);
        $this->assertFalse($model->widthSpeed);
        $this->assertSame([1000, 1000], $model->typeDurations);
    }

    /**
     * Test widthSpeed scales each line's typing time by its share of the widest width
     */
    public function testWidthSpeedScalesDurationByWidthShare(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b",
            "width" => "100;200",
            "duration" => "1000",
            "widthSpeed" => "true",
        ]);
        $this->assertTrue($model->widthSpeed);
        $this->assertSame([500, 1000], $model->typeDurations);
    }

    /**
     * Test a single width disables the scaling even when widthSpeed is on
     */
    public function testWidthSpeedWithSingleWidthKeepsFullDuration(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b",
            "width" => "300",
            "duration" => "1000",
            "widthSpeed" => "true",
        ]);
        $this->assertSame([1000, 1000], $model->typeDurations);
    }

    /**
     * Test a scaled duration never reaches zero milliseconds
     */
    public function testWidthSpeedKeepsEveryDurationPositive(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b",
            "width" => "1;1000",
            "duration" => "1",
            "widthSpeed" => "true",
        ]);
        $this->assertSame([1, 1], $model->typeDurations);
    }

    /**
     * Test random mode keeps each type duration with its line
     */
    public function testWidthSpeedFollowsLinesWhenRandomized(): void
    {
        $model = new RendererModel("src/templates/main.php", [
            "lines" => "a;b;c",
            "width" => "100;200;300",
            "duration" => "600",
            "widthSpeed" => "true",
            "random" => "true",
        ]);
        foreach ($model->lineWidths as $index => $width) {
            $this->assertSame(max(1, (int) round((600 * $width) / 300)), $model->typeDurations[$index]);
        }
    }
}
