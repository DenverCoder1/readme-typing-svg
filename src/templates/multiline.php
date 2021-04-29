<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
	xmlns:xlink='http://www.w3.org/1999/xlink'
	viewBox='0 0 <?php echo "$width $height" ?>'
	width='<?php echo $width ?>px' height='<?php echo $height ?>px'>

	<?php echo preg_replace("/\n/", "\n\t", $fontCSS); ?>

<?php $lineHeight = $size + 5;?>
<?php for ($i = 0; $i < count($lines); ++$i): ?>
    <path id='path<?php echo $i ?>'>
        <animate id='d<?php echo $i ?>' attributeName='d' dur='<?php echo 5 * ($i + 1) ?>s' fill="freeze"
            begin='0s;<?php echo "d" . (count($lines) - 1) ?>.end' keyTimes="0 ; <?php echo $i / ($i + 1); ?> ; 1"
            values='m0,<?php echo ($i + 1) * $lineHeight ?> h0 ; m0,<?php echo ($i + 1) * $lineHeight ?> h0 ; m0,<?php echo ($i + 1) * $lineHeight ?> h<?php echo $width ?>' />
    </path>
    <text font-family='"<?php echo $font ?>", monospace' fill='<?php echo $color ?>' font-size='<?php echo $size ?>'
<?php if ($center): ?>
        x='50%' dominant-baseline='middle' text-anchor='middle'>
<?php else: ?>
        x='0%' dominant-baseline='auto' text-anchor='start'>
<?php endif;?>
        <textPath xlink:href='#path<?php echo $i ?>'>
            <?php echo $lines[$i] . "\n" ?>
        </textPath>
    </text>

<?php endfor;?>
</svg>
