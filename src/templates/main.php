<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?php echo "$width $height" ?>'
    style='background-color: <?php echo $background ?>;'
    width='<?php echo $width ?>px' height='<?php echo $height ?>px'>

    <?php echo preg_replace("/\n/", "\n\t", $fontCSS); ?>

<?php $previousId = "d" . (count($lines) - 1);?>
<?php for ($i = 0; $i < count($lines); ++$i): ?>
    <path id='path<?php echo $i ?>'>
<?php if (!$multiline): ?>
        <animate id='d<?php echo $i ?>' attributeName='d' begin='<?php echo ($i == 0 ? "0s;" : "") . $previousId ?>.end' dur='<?php echo $duration ?>ms'
            values='m0,<?php echo $height / 2 ?> h0 ; m0,<?php echo $height / 2 ?> h<?php echo $width ?> ; m0,<?php echo $height / 2 ?> h0' keyTimes='0;0.8;1' />
<?php else: ?>
    <?php $lineHeight = $size + 5;?>
    <animate id='d<?php echo $i ?>' attributeName='d' dur='<?php echo $duration * ($i + 1) ?>ms' fill="freeze"
            begin='0s;<?php echo "d" . (count($lines) - 1) ?>.end' keyTimes="0;<?php echo $i / ($i + 1); ?>;1"
            values='m0,<?php echo ($i + 1) * $lineHeight ?> h0 ; m0,<?php echo ($i + 1) * $lineHeight ?> h0 ; m0,<?php echo ($i + 1) * $lineHeight ?> h<?php echo $width ?>' />
<?php endif;?>
    </path>
    <text font-family='"<?php echo $font ?>", monospace' fill='<?php echo $color ?>' font-size='<?php echo $size ?>'
<?php if ($vCenter): ?>
        dominant-baseline='middle'
<?php else: ?>
        dominant-baseline='auto'
<?php endif;?>
<?php if ($center): ?>
        x='50%' text-anchor='middle'>
<?php else: ?>
        x='0%' text-anchor='start'>
<?php endif;?>
        <textPath xlink:href='#path<?php echo $i ?>'>
            <?php echo $lines[$i] . "\n" ?>
        </textPath>
    </text>

<?php $previousId = "d" . $i;?>
<?php endfor;?>
</svg>
