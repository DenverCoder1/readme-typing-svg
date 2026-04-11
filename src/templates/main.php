<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?= "$width $height" ?>'
    style='background-color: <?= $background ?>;'
    width='<?= $width ?>px' height='<?= $height ?>px'>

    <?= $fontCSS ?>

    <?php $lastLineIndex = count($lines) - 1; ?>
    <?php
    // Pre-compute per-line group membership when groups param is provided
    $groupInfo = [];
    if ($groups !== null) {
        $lineIdx = 0;
        foreach ($groups as $gIdx => $gSize) {
            $groupStartLine = $lineIdx;
            for ($p = 0; $p < $gSize; $p++) {
                $groupInfo[$lineIdx] = [
                    "groupIndex" => $gIdx,
                    "positionInGroup" => $p,
                    "groupSize" => $gSize,
                    "groupStartLine" => $groupStartLine,
                    "lastLineInGroup" => $groupStartLine + $gSize - 1,
                    "isFirstGroup" => $gIdx === 0,
                ];
                $lineIdx++;
            }
        }
    }
    ?>
    <?php for ($i = 0; $i <= $lastLineIndex; ++$i): ?>
        <path id='path<?= $i ?>'>
            <?php if ($groups !== null): ?>
                <!-- Grouped lines: lines within a group type sequentially, all clear together -->
                <?php
                $info = $groupInfo[$i];
                $p = $info["positionInGroup"];
                $k = $info["groupSize"];
                $groupStartLine = $info["groupStartLine"];
                $lastLineInGroup = $info["lastLineInGroup"];

                $lineHeight = $size + 5;
                $yOffset = ($p + 1) * $lineHeight;
                $emptyLine = "m0,$yOffset h0";
                $fullLine = "m0,$yOffset h$width";

                // Total time for this group: each line occupies one $duration slot, plus one $pause at the end
                $groupDuration = $k * $duration + $pause;

                // keyTimes: wait for turn, type, hold through group pause, clear simultaneously with group
                $kt1 = ($p * $duration) / $groupDuration;
                $kt2 = (($p + 0.8) * $duration) / $groupDuration;
                $kt3 = (($k - 1 + 0.8) * $duration + $pause) / $groupDuration;
                $keyTimes = ["0", $kt1, $kt2, $kt3, "1"];
                $values = [$emptyLine, $emptyLine, $fullLine, $fullLine, $emptyLine];

                // All lines in a group share the same begin trigger
                if ($info["isFirstGroup"]) {
                    $begin = $repeat ? "0s;d{$lastLineIndex}.end" : "0s";
                } else {
                    $prevGroupLastLine = $groupStartLine - 1;
                    $begin = "d{$prevGroupLastLine}.end";
                }

                // Keep last group visible when repeat is disabled
                $freeze = !$repeat && $lastLineInGroup === $lastLineIndex;
                if ($freeze) {
                    $values[4] = $fullLine;
                }
                ?>
                <animate id='d<?= $i ?>' attributeName='d'
                    begin='<?= $begin ?>'
                    dur='<?= $groupDuration ?>ms'
                    fill='<?= $freeze ? "freeze" : "remove" ?>'
                    values='<?= implode(" ; ", $values) ?>'
                    keyTimes='<?= implode(";", $keyTimes) ?>' />
            <?php
                // start after previous line
                // if this is the first line, start at 0 seconds
                // and also after the last line if repeat is true
                // don't delete text after typing the last line if repeat is false
                // empty line values
                // keyTimes for the animation

                elseif (!$multiline): ?>
                <!-- Single line -->
                <?php
                $begin = "d" . ($i - 1) . ".end";
                if ($i == 0) {
                    $begin = $repeat ? "0s;d$lastLineIndex.end" : "0s";
                }
                $freeze = !$repeat && $i == $lastLineIndex;
                $yOffset = $height / 2;
                $emptyLine = "m0,$yOffset h0";
                $fullLine = "m0,$yOffset h$width";
                $values = [$emptyLine, $fullLine, $fullLine, $freeze ? $fullLine : $emptyLine];
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
                $emptyLine = "m0,$yOffset h0";
                $fullLine = "m0,$yOffset h$width";
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
        x='<?= $center ? "50%" : "0%" ?>' text-anchor='<?= $center ? "middle" : "start" ?>'
        letter-spacing='<?= $letterSpacing ?>'>
        <textPath xlink:href='#path<?= $i ?>'>
            <?= $lines[$i] . "\n" ?>
        </textPath>
    </text>
<?php endfor; ?>
</svg>
