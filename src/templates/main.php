<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?= "$width $height" ?>'
    style='background-color: <?= $background ?>;'
    width='<?= $width ?>px' height='<?= $height ?>px'>

    <?= preg_replace("/\n/", "\n\t", $fontCSS) ?>

<?php $previousId = "d" . (count($lines) - 1); ?>
<?php for ($i = 0; $i < count($lines); ++$i): ?>
    <path id='path<?= $i ?>'>
<?php if (!$multiline): ?>
        <animate id='d<?= $i ?>' attributeName='d' begin='<?= ($i == 0 ? "0s;" : "") .
    $previousId ?>.end' dur='<?= $duration + $pause ?>ms'
            values='m0,<?= $height / 2 ?> h0 ; m0,<?= $height / 2 ?> h<?= $width ?> ; m0,<?= $height /
     2 ?> h<?= $width ?> ; m0,<?= $height / 2 ?> h0'
            keyTimes='0;<?= (0.8 * $duration) / ($duration + $pause) ?>;<?= (0.8 * $duration + $pause) /
    ($duration + $pause) ?>;1' />
<?php else: ?>
    <?php $lineHeight = $size + 5; ?>
    <animate id='d<?= $i ?>' attributeName='d' dur='<?= ($duration + $pause) * ($i + 1) ?>ms' fill="freeze"
            begin='0s;<?= "d" . (count($lines) - 1) ?>.end' keyTimes='0;<?= $i / ($i + 1) ?>;<?= $i / ($i + 1) +
    $duration / (($duration + $pause) * ($i + 1)) ?>;1'
            values='m0,<?= ($i + 1) * $lineHeight ?> h0 ; m0,<?= ($i + 1) * $lineHeight ?> h0 ; m0,<?= ($i + 1) *
     $lineHeight ?> h<?= $width ?> ; m0,<?= ($i + 1) * $lineHeight ?> h<?= $width ?>' />
<?php endif; ?>
    </path>
    <text font-family='"<?= $font ?>", monospace' fill='<?= $color ?>' font-size='<?= $size ?>'
<?php if ($vCenter): ?>
        dominant-baseline='middle'
<?php else: ?>
        dominant-baseline='auto'
<?php endif; ?>
<?php if ($center): ?>
        x='50%' text-anchor='middle'>
<?php else: ?>
        x='0%' text-anchor='start'>
<?php endif; ?>
        <textPath xlink:href='#path<?= $i ?>'>
            <?= $lines[$i] . "\n" ?>
        </textPath>
    </text>

<?php $previousId = "d" . $i; ?>
<?php endfor; ?>
</svg>
