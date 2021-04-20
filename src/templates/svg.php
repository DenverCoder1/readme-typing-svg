<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
	xmlns:xlink='http://www.w3.org/1999/xlink'
	viewBox='0 0 <?php echo "{$width} {$height}"; ?>'
	width='<?php echo "{$width}"; ?>px' height='<?php echo "{$height}"; ?>px'>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=<?php echo str_replace(" ", "+", $font); ?>');
	</style>
<?php
// number of lines
$numLines = count($lines);
// initialize previousId to id of the last line
$previousId = "d" . $numLines - 1;
// add text and paths for each line
for ($i = 0; $i < $numLines; ++$i) {
    // add line of text to svg
    echo "
    <path id='path{$i}'>
        <animate id='d{$i}' attributeName='d' begin='" . ($i == 0 ? "0s;" : "") . "{$previousId}.end' dur='5s'
            values='m0," . ($height / 2) . " h0 ; m0," . ($height / 2) . " h{$width} ; m0," . ($height / 2) . " h0' keyTimes='0 ; 0.8 ; 1' />
    </path>
    <text font-family='{$font}, monospace' fill='{$color}' font-size='{$size}'" .
        ($center ? " x='50%' dominant-baseline='middle' text-anchor='middle'" : "") . ">
        <textPath xlink:href='#path{$i}'>
            {$lines[$i]}
        </textPath>
    </text>
";
    $previousId = "d" . $i;
}
?>
</svg>
