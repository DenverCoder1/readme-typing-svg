<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?= "$width $height" ?>'
    style='background-color: <?= $background ?>;'
    width='<?= $width ?>px' height='<?= $height ?>px'>

    <?= $fontCSS ?>

    <?php $lastLineIndex = count($lines) - 1; ?>
    <?php for ($i = 0; $i <= $lastLineIndex; ++$i): ?>
        <path id='path<?= $i ?>'>
            <?php if (!$multiline): ?>
                <!-- Single line -->
                <?php
                // start after previous line
                $begin = "d" . ($i - 1) . ".end";
                if ($i == 0) {
                    // if this is the first line, start at 0 seconds
                    // and also after the last line if repeat is true
                    $begin = $repeat ? "0s;d$lastLineIndex.end" : "0s";
                }
                // don't delete text after typing the last line if repeat is false
                $freeze = !$repeat && $i == $lastLineIndex;
                // empty line values
                $yOffset = $height / 2;
                // rtl true means writing from the right, else, behaves normally
                if ($rtl === true) {
                    $emptyLine = "m$width,$yOffset h0";
                    $fullLine = "m$width,$yOffset h-$width";
                } else {
                    $emptyLine = "m0,$yOffset h0";
                    $fullLine = "m0,$yOffset h$width";
                }
                $values = [$emptyLine, $fullLine, $fullLine, $freeze ? $fullLine : $emptyLine];
                // keyTimes for the animation
                $keyTimes = [
                    "0",
                    (0.8 * $duration) / ($duration + $pause),
                    (0.8 * $duration + $pause) / ($duration + $pause),
                    "1",
                ];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='<?= $begin ?>'
                    dur='<?= $duration + $pause ?>ms' fill='<?= $freeze ? "freeze" : "remove" ?>'
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
            <?php else: ?>
                <!-- Multiline -->
                <?php
                $nextIndex = $i + 1;
                $lineHeight = $size + 5;
                $lineDuration = ($duration + $pause) * $nextIndex;
                $yOffset = $nextIndex * $lineHeight;
                if ($rtl === true) {
                    $emptyLine = "m$width,$yOffset h0";
                    $fullLine = "m$width,$yOffset h-$width";
                } else {
                    $emptyLine = "m0,$yOffset h0";
                    $fullLine = "m0,$yOffset h$width";
                }
                $values = [$emptyLine, $emptyLine, $fullLine, $fullLine];
                $keyTimes = ["0", $i / $nextIndex, $i / $nextIndex + $duration / $lineDuration, "1"];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='0s<?= $repeat ? ";d$lastLineIndex.end" : "" ?>'
                    dur='<?= $lineDuration ?>ms' fill="freeze"
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
            <?php endif; ?>
        </path>
    <text font-family='"<?= $font ?>", monospace' fill='<?= $color ?>' font-size='<?= $size ?>'
        dominant-baseline='<?= $vCenter ? "middle" : "auto" ?>'
        x='<?= $center ? "50%" : "0%" ?>' text-anchor='<?= $center ? "middle" : "start" ?>'>
        <textPath xlink:href='#path<?= $i ?>'>
            <?= $lines[$i] . "\n" ?>
        </textPath>
    </text>
<?php endfor; ?>
</svg>
