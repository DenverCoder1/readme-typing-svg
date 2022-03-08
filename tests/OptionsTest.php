<?php declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

final class OptionsTest extends TestCase
{
    protected static $database;

    public static function setUpBeforeClass(): void
    {
        self::$database = new DatabaseConnection();
    }

    /**
     * Test exception thrown when missing 'lines' parameter
     */
    public function testMissingLines(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Lines parameter must be set.");
        $params = array(
            "center" => "true",
            "width" => "380",
            "height" => "50",
        );
        print_r(new RendererModel("src/templates/main.php", $params, self::$database));
    }

    /**
     * Test valid font
     */
    public function testValidFont(): void
    {
        $params = array(
            "lines" => "text",
            "font" => "Open Sans",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals("Open Sans", $model->font);
    }

    /**
     * Test valid font color
     */
    public function testValidFontColor(): void
    {
        $params = array(
            "lines" => "text",
            "color" => "000000",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals("#000000", $model->color);
    }

    /**
     * Test invalid font color
     */
    public function testInvalidFontColor(): void
    {
        $params = array(
            "lines" => "text",
            "color" => "00000",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals("#36BCF7", $model->color);
    }

    /**
     * Test valid background color
     */
    public function testValidBackgroundColor(): void
    {
        $params = array(
            "lines" => "text",
            "background" => "00000033",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals("#00000033", $model->background);
    }

    /**
     * Test invalid background color
     */
    public function testInvalidBackgroundColor(): void
    {
        $params = array(
            "lines" => "text",
            "background" => "00000",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals("#36BCF7", $model->background);
    }

    /**
     * Test valid font size
     */
    public function testValidFontSize(): void
    {
        $params = array(
            "lines" => "text",
            "size" => "18",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(18, $model->size);
    }

    /**
     * Test exception thrown when font size is invalid
     */
    public function testInvalidFontSize(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Font size must be a positive number.");
        $params = array(
            "lines" => "text",
            "size" => "0",
        );
        print_r(new RendererModel("src/templates/main.php", $params, self::$database));
    }

    /**
     * Test valid height
     */
    public function testValidHeight(): void
    {
        $params = array(
            "lines" => "text",
            "height" => "80",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(80, $model->height);
    }

    /**
     * Test exception thrown when height is invalid
     */
    public function testInvalidHeight(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Height must be a positive number.");
        $params = array(
            "lines" => "text",
            "height" => "x",
        );
        print_r(new RendererModel("src/templates/main.php", $params, self::$database));
    }

    /**
     * Test valid width
     */
    public function testValidWidth(): void
    {
        $params = array(
            "lines" => "text",
            "width" => "500",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(500, $model->width);
    }

    /**
     * Test exception thrown when width is invalid
     */
    public function testInvalidWidth(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Width must be a positive number.");
        $params = array(
            "lines" => "text",
            "width" => "-1",
        );
        print_r(new RendererModel("src/templates/main.php", $params, self::$database));
    }

    /**
     * Test center set to true
     */
    public function testCenterIsTrue(): void
    {
        $params = array(
            "lines" => "text",
            "center" => "true",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(true, $model->center);
    }

    /**
     * Test center not set to true
     */
    public function testCenterIsNotTrue(): void
    {
        $params = array(
            "lines" => "text",
            "center" => "other",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(false, $model->center);
    }
    
    /**
     * Test vCenter set to true
     */
    public function testVCenterIsTrue(): void
    {
        $params = array(
            "lines" => "text",
            "vCenter" => "true",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(true, $model->vCenter);
    }

    /**
     * Test vCenter not set to true
     */
    public function testVCenterIsNotTrue(): void
    {
        $params = array(
            "lines" => "text",
            "vCenter" => "other",
        );
        $model = new RendererModel("src/templates/main.php", $params, self::$database);
        $this->assertEquals(false, $model->vCenter);
    }
}
