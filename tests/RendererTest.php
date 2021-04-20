<?php declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require_once "src/models/RendererModel.php";
require_once "src/views/RendererView.php";
require_once "src/models/ErrorModel.php";
require_once "src/views/ErrorView.php";

final class RendererTest extends TestCase
{
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
            "width" => "380",
            "height" => "50",
        );
        $model = new RendererModel("src/templates/main.php", $params);
        $view = new RendererView($model);
        $this->assertEquals(file_get_contents("tests/svg/test_normal.svg"), $view->output());
    }

    /**
     * Test error card render
     */
    public function testErrorCardRender(): void
    {
        // missing lines
        $params = array(
            "center" => "true",
            "width" => "380",
            "height" => "50",
        );
        try {
            // create renderer model
            $model = new RendererModel("src/templates/main.php", $params);
            $view = new RendererView($model);
        } catch (InvalidArgumentException $error) {
            // create error rendering model
            $model = new ErrorModel("src/templates/error.php", $error->getMessage());
            $view = new ErrorView($model);
        }
        $this->assertEquals(file_get_contents("tests/svg/test_missing_lines.svg"), $view->output());
    }
}
