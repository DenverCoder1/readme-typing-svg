<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require "vendor/autoload.php";

final class OptionsValidationTest extends TestCase
{
    /**
     * Test exception thrown when font weight is zero
     */
    public function testZeroFontWeight(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Font weight must be a positive number.");
        $params = [
            "lines" => "text",
            "weight" => "0",
        ];
        new RendererModel("src/templates/main.php", $params);
    }

    /**
     * Test exception thrown when font weight is negative
     */
    public function testNegativeFontWeight(): void
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("Font weight must be a positive number.");
        $params = [
            "lines" => "text",
            "weight" => "-5",
        ];
        new RendererModel("src/templates/main.php", $params);
    }

    /**
     * Test color parameter keeps a preceding hash symbol
     */
    public function testColorWithHashPrefix(): void
    {
        $params = [
            "lines" => "text",
            "color" => "#FF0000",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#FF0000", $model->color);
    }

    /**
     * Test 3-digit shorthand hex color is accepted
     */
    public function testColorShorthandHex(): void
    {
        $params = [
            "lines" => "text",
            "color" => "f00",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#f00", $model->color);
    }

    /**
     * Test 8-digit hex color with alpha channel is accepted
     */
    public function testColorWithAlphaChannel(): void
    {
        $params = [
            "lines" => "text",
            "color" => "FF000080",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#FF000080", $model->color);
    }

    /**
     * Test non-hex characters are stripped before validating color length
     */
    public function testColorSanitizesInvalidCharacters(): void
    {
        $params = [
            "lines" => "text",
            "color" => "g1h2i3",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals("#123", $model->color);
    }

    /**
     * Test boolean parameters are parsed case-insensitively
     */
    public function testBooleanIsCaseInsensitive(): void
    {
        $params = [
            "lines" => "text",
            "center" => "TRUE",
            "vCenter" => "True",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertTrue($model->center);
        $this->assertTrue($model->vCenter);
    }

    /**
     * Test group sizes may contain whitespace around commas
     */
    public function testGroupsAllowWhitespaceAroundCommas(): void
    {
        $params = [
            "lines" => "a;b;c",
            "groups" => "2, 1",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertEquals([2, 1], $model->groups);
    }

    /**
     * Test an empty groups parameter disables grouped animation
     */
    public function testEmptyGroupsParameterReturnsNull(): void
    {
        $params = [
            "lines" => "a;b;c",
            "groups" => "",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        $this->assertNull($model->groups);
    }

    /**
     * Test shuffling keeps lines of each group together and in order
     */
    public function testShuffleKeepsGroupLinesTogether(): void
    {
        $params = [
            "lines" => "a;b;c",
            "groups" => "2,1",
            "random" => "true",
        ];
        $model = new RendererModel("src/templates/main.php", $params);
        // the group [a, b] must stay contiguous and ordered; only whole groups may swap positions
        $this->assertTrue(
            $model->lines === ["a", "b", "c"] || $model->lines === ["c", "a", "b"],
            "Lines within a group must stay together and in order when shuffled"
        );
    }
}
