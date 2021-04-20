<?php declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require_once "src/models/RendererModel.php";
require_once "src/views/RendererView.php";

final class OptionsTest extends TestCase
{
    /**
     * Test exception thrown when missing 'lines' parameter
     */
    public function testMissingLines(): void
    {
        $this->expectException("InvalidArgumentException");
        $params = array(
            "center" => "true",
            "width" => "380",
            "height" => "50",
        );
        new RendererModel("src/templates/main.php", $params);
    }
}
