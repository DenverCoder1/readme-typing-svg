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
                // Wait for every line before this one in the group to finish typing
                $groupTypedBefore = 0;
                for ($q = 0; $q < $p; $q++) {
                    $groupTypedBefore += $typeDurations[$groupStartLine + $q];
                }
                $groupLineStarts[$lineIndex] = $delayPrefix + $groupTypedBefore;
            }
            $groupDelays[$gIdx] = $delayPrefix;
            $lineIdx += $gSize;
        }
    }
    // Multiline lines type one after another, so each one needs the total typing
    // time of every line before it and the delays accumulated so far. Both match
    // the original maths ($i * $duration, sum of delays up to $i) when widthSpeed is off.
    $lineTypes = [];
    $lineDelays = [];
    $typeTotal = 0;
    $delayTotal = 0;
    foreach ($typeDurations as $lineIdx => $typeDuration) {
        $lineTypes[] = $typeTotal;
        $delayTotal += $delay[$lineIdx];
        $lineDelays[] = $delayTotal;
        $typeTotal += $typeDuration;
    }
    ?>
    <?php for ($i = 0; $i <= $lastLineIndex; ++$i): ?>
        <?php
        // Each line is typed across its own width; centered lines start part way in
        $lineWidth = $lineWidths[$i];
        $xStart = $center ? ($width - $lineWidth) / 2 : 0;
        $textX = $center ? ($lineWidth === $width ? "50%" : $lineWidth / 2) : "0%";
        // Typing time for this line; equals $duration unless widthSpeed is enabled
        $typeDuration = $typeDurations[$i];
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
                $groupTyping = 0;
                $groupLastLineEnd = 0;
                foreach ($groupInfo as $lineIdx => $lineInfo) {
                    if ($lineInfo["groupIndex"] === $info["groupIndex"]) {
                        $groupTyping += $typeDurations[$lineIdx];
                        $groupLastLineEnd = $groupLineStarts[$lineIdx] + $typeDurations[$lineIdx];
                    }
                }
                $groupDuration = $groupDelay + $groupTyping + $pause;

                // Each line waits for its own delay and the preceding lines in the group.
                $lineStart = $groupLineStarts[$i];
                $kt1 = $lineStart / $groupDuration;
                $kt2 = ($lineStart + 0.8 * $typeDuration) / $groupDuration;
                // hold the finished line at 20% growth until the group's last line stops typing
                $kt3 = ($groupLastLineEnd - 0.2 * $typeDurations[$lastLineInGroup] + $pause) / $groupDuration;
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
                    (0.8 * $typeDuration) / ($typeDuration + $pause),
                    (0.8 * $typeDuration + $pause) / ($typeDuration + $pause),
                    "1",
                ];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='<?= $begin ?>'
                    dur='<?= $typeDuration + $pause ?>ms' fill='<?= $freeze ? "freeze" : "remove" ?>'
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
            <?php else: ?>
                <!-- Multiline -->
                <?php
                $nextIndex = $i + 1;
                $lineHeight = $size + 5;
                $cumulativeDelay = $lineDelays[$i];
                $lineDuration = $lineTypes[$i] + $typeDuration + $pause * $nextIndex + $cumulativeDelay;
                $lineStart = $lineTypes[$i] + $pause * $i + $cumulativeDelay;
                $yOffset = $nextIndex * $lineHeight;
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";
                $values = [$emptyLine, $emptyLine, $fullLine, $fullLine];
                $keyTimes = ["0", $lineStart / $lineDuration, ($lineStart + $typeDuration) / $lineDuration, "1"];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='0s<?= $repeat ? ";d$lastLineIndex.end" : "" ?>'
                    dur='<?= $lineDuration ?>ms' fill="freeze"
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
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
<?php endfor; ?>
</svg>
