
    <path id='path<?php echo $i ?>'>
        <animate id='d<?php echo $i ?>' attributeName='d' begin='<?php echo ($i == 0 ? "0s;" : "") . $previousId ?>.end' dur='5s'
            values='m0,<?php echo $height / 2 ?> h0 ; m0,<?php echo $height / 2 ?> h<?php echo $width ?> ; m0,<?php echo $height / 2 ?> h0' keyTimes='0 ; 0.8 ; 1' />
    </path>

    <text font-family='<?php echo $font ?>, monospace' fill='<?php echo $color ?>' font-size='<?php echo $size ?>'
<?php if ($center): ?>
        x='50%' dominant-baseline='middle' text-anchor='middle'>
<?php else: ?>
        x='0%' dominant-baseline='auto' text-anchor='start'>
<?php endif;?>
        <textPath xlink:href='#path<?php echo $i ?>'>
            <?php echo $lines[$i] . "\n" ?>
        </textPath>
    </text>
