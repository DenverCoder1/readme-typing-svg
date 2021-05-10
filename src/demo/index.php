<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-48CYVH0XEF"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-48CYVH0XEF');
    </script>
    <title>Readme Typing SVG - Demo Site</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <link href="https://css.gg/css?=|moon|sun" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/loader.css">
    <link rel="stylesheet" href="./css/toggle-dark.css">
    <script type="text/javascript" src="./js/script.js" defer></script>
    <script type="text/javascript" src="./js/toggle-dark.js" defer></script>
    <script type="text/javascript" src="./js/jscolor.min.js" defer></script>
</head>

<body <?php echo $_COOKIE["darkmode"] == "on" ? 'data-theme="dark"' : ""; ?>>
    <h1>⌨️ Readme Typing SVG</h1>

    <!-- GitHub badges/links section -->
    <div class="github">
        <!-- GitHub Sponsors -->
        <a class="github-button" href="https://github.com/sponsors/denvercoder1"
            data-color-scheme="no-preference: light; light: light; dark: dark;" data-icon="octicon-heart"
            data-size="large" aria-label="Sponsor @denvercoder1 on GitHub">Sponsor</a>
        <!-- View on GitHub -->
        <a class="github-button" href="https://github.com/denvercoder1/unicode-formatter"
            data-color-scheme="no-preference: light; light: light; dark: dark;" data-size="large"
            aria-label="View denvercoder1/unicode-formatter on GitHub">View on GitHub</a>
        <!-- GitHub Star -->
        <a class="github-button" href="https://github.com/denvercoder1/unicode-formatter"
            data-color-scheme="no-preference: light; light: light; dark: dark;" data-icon="octicon-star"
            data-size="large" data-show-count="true" aria-label="Star denvercoder1/unicode-formatter on GitHub">Star</a>
    </div>

    <div class="container">
        <div class="properties">
            <h2>Add your text</h2>
            <form class="parameters three-columns lines"><!-- Lines are added in JavaScript --></form>
            <button class="add-line btn" onclick="return preview.addLine();">+ Add line</button>

            <h2>Options</h2>
            <form class="parameters two-columns options">
                <label for="font">Font</label>
                <input class="param" type="text" id="font" name="font" placeholder="monospace" value="monospace"
                    pattern="^[A-Za-z0-9\- ]*$" title="Font from Google Fonts. Only letters, numbers, and spaces.">

                <label for="color">Font color</label>
                <input class="param jscolor jscolor-active" id="color" name="background"
                    data-jscolor="{ format: 'hexa' }" value="#36BCF7">

                <label for="size">Font size</label>
                <input class="param" type="number" id="size" name="size" placeholder="20" value="20">

                <label for="center">Horizontally Centered</label>
                <select class="param" id="center" name="center" value="false">
                    <option>false</option>
                    <option>true</option>
                </select>
                
                <label for="vCenter">Vertically Centered</label>
                <select class="param" id="vCenter" name="vCenter" value="false">
                    <option>false</option>
                    <option>true</option>
                </select>

                <label for="multiline">Multiline</label>
                <select class="param" id="multiline" name="multiline" value="false">
                    <option value="false">Type sentences on one line</option>
                    <option value="true">Each sentence on a new line</option>
                </select>

                <label for="dimensions">W ✕ H</label>
                <span id="dimensions">
                    <input class="param inline" type="number" id="width" name="width" placeholder="400" value="400">
                    <label>✕</label>
                    <input class="param inline" type="number" id="height" name="height" placeholder="50" value="50">
                </span>
            </form>
        </div>

        <div class="output">
            <h2>Preview</h2>

            <img alt="Readme Typing SVG" src="/?lines=The+five+boxing+wizards+jump+quickly"
                onload="this.classList.remove('loading')" onerror="this.classList.remove('loading')" />
            <div class="loader">Loading...</div>

            <label class="show-border">
                <input type="checkbox">
                Show border
            </label>

            <h2>Markdown</h2>
            <div class="md">
                <code></code>
            </div>

            <button class="copy-button btn tooltip" onclick="clipboard.copy(this);" onmouseout="tooltip.reset(this);" disabled>
                Copy To Clipboard
            </button>
        </div>
    </div>

    <a href="javascript:toggleTheme()" class="darkmode" title="toggle dark mode">
        <i class="<?php echo $_COOKIE["darkmode"] == "on" ? 'gg-sun' : "gg-moon"; ?>"></i>
    </a>
</body>

</html>
