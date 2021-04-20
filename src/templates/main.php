<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
	xmlns:xlink='http://www.w3.org/1999/xlink'
	viewBox='0 0 <?php echo "{$width} {$height}"; ?>'
	width='<?php echo "{$width}"; ?>px' height='<?php echo "{$height}"; ?>px'>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=<?php echo str_replace(" ", "+", $font); ?>');
	</style>
<?php
// initialize previousId to id of the last line
$previousId = "d" . count($lines) - 1;
// add text and paths for each line
for ($i = 0; $i < count($lines); ++$i) {
    // add line of text to svg
    require "line.php";
    // set previousId to current id
    $previousId = "d" . $i;
}
?>
</svg>
