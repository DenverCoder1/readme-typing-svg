<!-- https://github.com/DenverCoder1/readme-typing-svg/ -->
<svg xmlns='http://www.w3.org/2000/svg'
    xmlns:xlink='http://www.w3.org/1999/xlink'
    viewBox='0 0 <?= "$width $height" ?>'
    style='background-color: <?= $background ?>;'
    width='<?= $width ?>px' height='<?= $height ?>px'>

    <?= $fontCSS ?>

    <?php $lastLineIndex = count($lines) - 1; ?>
    <?php
    $cumulativeDelay = 0;
    $cumulativeTyping = 0;
    ?>
    <?php
    // Pre-compute per-line group membership when groups param is provided
    $groupInfo = [];
    $groupDelays = [];
    $groupTypingDurations = [];
    $groupLineStarts = [];
    if ($groups !== null) {
        $lineIdx = 0;
        foreach ($groups as $gIdx => $gSize) {
            $groupStartLine = $lineIdx;
            $delayPrefix = 0;
            $typingPrefix = 0;
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
                $groupLineStarts[$lineIndex] = $delayPrefix + $typingPrefix;
                $typingPrefix += $typeDurations[$lineIndex];
            }
            $groupDelays[$gIdx] = $delayPrefix;
            $groupTypingDurations[$gIdx] = $typingPrefix;
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
                $groupStartLine = $info["groupStartLine"];
                $lastLineInGroup = $info["lastLineInGroup"];

                $lineHeight = $size + 5;
                $yOffset = ($p + 1) * $lineHeight;
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";

                // Delays are waits immediately before each line starts typing.
                $groupDelay = $groupDelays[$info["groupIndex"]];
                $groupTyping = $groupTypingDurations[$info["groupIndex"]];
                $groupDuration = $groupDelay + $groupTyping + $pause;
                $lineTypeDuration = $typeDurations[$i];

                // Each line waits for its own delay and the preceding lines in the group.
                $lineStart = $groupLineStarts[$i];
                $kt1 = $lineStart / $groupDuration;
                $kt2 = ($lineStart + 0.8 * $lineTypeDuration) / $groupDuration;
                $lastLineTypeDuration = $typeDurations[$lastLineInGroup];
                $kt3 = ($groupDelay + $groupTyping - 0.2 * $lastLineTypeDuration + $pause) / $groupDuration;
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
                $lineTypeDuration = $typeDurations[$i];
                $animationDuration = $lineTypeDuration + $pause;
                $keyTimes = [
                    "0",
                    (0.8 * $lineTypeDuration) / $animationDuration,
                    (0.8 * $lineTypeDuration + $pause) / $animationDuration,
                    "1",
                ];
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='<?= $begin ?>'
                    dur='<?= $animationDuration ?>ms' fill='<?= $freeze ? "freeze" : "remove" ?>'
                    values='<?= implode(" ; ", $values) ?>' keyTimes='<?= implode(";", $keyTimes) ?>' />
            <?php else: ?>
                <!-- Multiline -->
                <?php
                $nextIndex = $i + 1;
                $lineHeight = $size + 5;
                $cumulativeDelay += $delay[$i];
                $lineStart = $cumulativeDelay + $cumulativeTyping;
                $animationDuration = $lineStart + $typeDurations[$i] + $pause;
                $yOffset = $nextIndex * $lineHeight;
                $emptyLine = "m$xStart,$yOffset h0";
                $fullLine = "m$xStart,$yOffset h$lineWidth";
                $values = [$emptyLine, $emptyLine, $fullLine, $fullLine];
                $keyTimes = [
                    "0",
                    $lineStart / $animationDuration,
                    ($lineStart + $typeDurations[$i]) / $animationDuration,
                    "1",
                ];
                $cumulativeTyping += $typeDurations[$i] + $pause;
                ?>
                <animate id='d<?= $i ?>' attributeName='d' begin='0s<?= $repeat ? ";d$lastLineIndex.end" : "" ?>'
                    dur='<?= $animationDuration ?>ms' fill="freeze"
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
