<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?= "$width $height" ?>'
    style='background-color: <?= $background ?>;'
    width='<?= $width ?>px' height='<?= $height ?>px'>

    <?= $fontCSS ?>

    <?php $lastLineIndex = count($lines) - 1; ?>
    <?php
    // Cursor block: geometry and blink timing, recomputed per line.
    if ($cursor) {
        $cursorWidth = max(1, (int) round($size * 0.5));
        $cursorHeight = (int) round($size);
        $cursorBlinkMs = 1000;
        $cursorBlinkBegin = "0s";
    }
    ?>
    <?php
    // Pre-compute per-line group membership when groups param is provided
    $groupInfo = [];
    $groupDelays = [];
    $groupLineStarts = [];
    if ($groups !== null) {
        $lineIdx = 0;
        foreach ($groups as $gIdx => $gSize) {
            $groupStartLine = $lineIdx;
            $delayPrefix = 0;
            for ($p = 0; $p < $gSize; $p++) {
                $lineIndex = $lineIdx + $p;
                $delayPrefix += $delay[$lineIndex];
                $groupInfo[$lineIndex] = [
                    "groupIndex" => $gIdx,
                    "positionInGroup" => $p,
                    "groupSize" => $gSize,
                    "groupStartLine" => $groupStartLine,
                    "lastLineInGroup" => $groupStartLine + $gSize - 1,
                    "isFirstGroup" => $gIdx === 0,
                ];
                $groupLineStarts[$lineIndex] = $delayPrefix + $p * $duration;
            }
            $groupDelays[$gIdx] = $delayPrefix;
            $lineIdx += $gSize;
        }
    }
    ?>
    <?php for ($i = 0; $i <= $lastLineIndex; ++$i): ?>
        <?php
        // Each line is typed across its own width; centered lines start part way in
        $lineWidth = $lineWidths[$i];
        $xStart = $center ? ($width - $lineWidth) / 2 : 0;
        $textX = $center ? ($lineWidth === $width ? "50%" : $lineWidth / 2) : "0%";
        ?>
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
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";

                // Delays are waits immediately before each line starts typing.
                $groupDelay = $groupDelays[$info["groupIndex"]];
                $groupDuration = $groupDelay + $k * $duration + $pause;

                // Each line waits for its own delay and the preceding lines in the group.
                $lineStart = $groupLineStarts[$i];
                $kt1 = $lineStart / $groupDuration;
                $kt2 = ($lineStart + 0.8 * $duration) / $groupDuration;
                $kt3 = ($groupDelay + ($k - 1 + 0.8) * $duration + $pause) / $groupDuration;
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
                // Cursor rides to the group's last line end, then clears with the group
                $cursorBegin = $begin;
                $cursorDur = $groupDuration;
                if ($cursor) { $cursorY = $vCenter ? $yOffset - $cursorHeight / 2 : $yOffset - $size * 0.8; }
                $cursorKeyTimes = $keyTimes;
                $cursorXs = [$xStart, $xStart + $lineWidth, $xStart + $lineWidth, $freeze ? $xStart + $lineWidth : $xStart];
                $cursorFill = $freeze ? "freeze" : "remove";
                $cursorBlinkBegin = $begin;
                ?>
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
                $lineDelay = $delay[$i];
                $delayOffset = $lineDelay > 0 ? "+{$lineDelay}ms" : "";
                if ($i == 0) {
                    $initialBegin = $lineDelay > 0 ? "{$lineDelay}ms" : "0s";
                    $begin = $repeat ? "{$initialBegin};d$lastLineIndex.end$delayOffset" : $initialBegin;
                } else {
                    $begin = "d" . ($i - 1) . ".end$delayOffset";
                }
                $freeze = !$repeat && $i == $lastLineIndex;
                $yOffset = $height / 2;
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";
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
                <?php
                // Cursor mirrors the line's reveal: it rides to the end of the text, holds, then resets
                $cursorBegin = $begin;
                $cursorDur = $duration + $pause;
                $cursorKeyTimes = $keyTimes;
                $cursorXs = [$xStart, $xStart + $lineWidth, $xStart + $lineWidth, $freeze ? $xStart + $lineWidth : $xStart];
                $cursorFill = $freeze ? "freeze" : "remove";
                if ($cursor) { $cursorY = $vCenter ? $yOffset - $cursorHeight / 2 : $yOffset - $size * 0.8; }
                $cursorBlinkBegin = $cursorBegin;
                ?>
            <?php else: ?>
                <!-- Multiline -->
                <?php
                $nextIndex = $i + 1;
                $lineHeight = $size + 5;
                $cumulativeDelay = ($i === 0 ? 0 : $cumulativeDelay) + $delay[$i];
                $lineDuration = ($duration + $pause) * $nextIndex + $cumulativeDelay;
                $lineStart = $i * ($duration + $pause) + $cumulativeDelay;
                $yOffset = $nextIndex * $lineHeight;
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";
                $values = [$emptyLine, $emptyLine, $fullLine, $fullLine];
                $keyTimes = ["0", $lineStart / $lineDuration, ($lineStart + $duration) / $lineDuration, "1"];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='0s<?= $repeat ? ";d$lastLineIndex.end" : "" ?>'
                    dur='<?= $lineDuration ?>ms' fill="freeze"
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
                <?php
                // Cursor appears with the line and stops at its end
                $cursorBegin = "0s" . ($repeat ? ";d$lastLineIndex.end" : "");
                $cursorDur = $lineDuration;
                $cursorKeyTimes = ["0", "0", $keyTimes[2], "1"];
                $cursorXs = [$xStart, $xStart, $xStart + $lineWidth, $xStart + $lineWidth];
                $cursorFill = "freeze";
                if ($cursor) { $cursorY = $vCenter ? $yOffset - $cursorHeight / 2 : $yOffset - $size * 0.8; }
                $cursorBlinkBegin = "0s";
                ?>
            <?php endif; ?>
        </path>
    <text font-family='"<?= $font ?>", monospace' fill='<?= $color ?>' font-size='<?= $size ?>'
        dominant-baseline='<?= $vCenter ? "middle" : "auto" ?>'
        x='<?= $textX ?>' text-anchor='<?= $center ? "middle" : "start" ?>'
        letter-spacing='<?= $letterSpacing ?>'>
        <textPath xlink:href='#path<?= $i ?>'>
            <?= $lines[$i] . "\n" ?>
        </textPath>
    </text>
    <?php if ($cursor): ?>
        <!-- Cursor: a block that rides the same path as the text, so it tracks the typed edge -->
        <rect x='0' y='<?= $cursorY ?>' width='<?= $cursorWidth ?>' height='<?= $cursorHeight ?>' fill='<?= $color ?>'>
            <animate attributeName='x' dur='<?= $cursorDur ?>ms' begin='<?= $cursorBegin ?>'
                values='<?= implode(" ; ", $cursorXs) ?>' keyTimes='<?= implode(";", $cursorKeyTimes) ?>'
                fill='<?= $cursorFill ?>' />
            <animate attributeName='opacity' values='1;1;0;0;1' dur='<?= $cursorBlinkMs ?>ms'
                begin='<?= $cursorBlinkBegin ?>' repeatCount='indefinite' />
        </rect>
    <?php endif; ?>
<?php endfor; ?>
</svg>
