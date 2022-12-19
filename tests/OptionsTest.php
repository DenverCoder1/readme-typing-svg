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
}
