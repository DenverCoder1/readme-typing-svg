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

        function gtag() {
            dataLayer.push(arguments);
        }
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
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <link rel="icon" type="image/png" href="favicon.png">
</head>

<body <?= isset($_COOKIE["darkmode"]) && $_COOKIE["darkmode"] == "on" ? 'data-theme="dark"' : "" ?>>
    <h1>⌨️ Readme Typing SVG</h1>

    <!-- GitHub badges/links section -->
    <div class="github">
        <!-- GitHub Sponsors -->
        <a class="github-button" href="https://github.com/sponsors/denvercoder1" data-color-scheme="no-preference: light; light: light; dark: dark;" data-icon="octicon-heart" data-size="large" aria-label="Sponsor @denvercoder1 on GitHub">Sponsor</a>
        <!-- View on GitHub -->
        <a class="github-button" href="https://github.com/denvercoder1/readme-typing-svg" data-color-scheme="no-preference: light; light: light; dark: dark;" data-size="large" aria-label="View denvercoder1/readme-typing-svg on GitHub">View on GitHub</a>
        <!-- GitHub Star -->
        <a class="github-button" href="https://github.com/denvercoder1/readme-typing-svg" data-color-scheme="no-preference: light; light: light; dark: dark;" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star denvercoder1/readme-typing-svg on GitHub">Star</a>
    </div>

    <div class="container">
        <div class="properties">
            <h2>Add your text</h2>
            <form class="parameters three-columns lines">
                <!-- Lines are added in JavaScript -->
            </form>
            <button class="add-line btn" onclick="return preview.addLines(1);">+ Add line</button>

            <h2>Options</h2>
            <form class="parameters two-columns options">
                <div class="label-group">
                    <label for="font">Font</label>
                    <a href="https://fonts.google.com/" target="_blank" class="icon tooltip" title="Enter a font name from Google Fonts">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6C9.831 6 8.066 7.765 8.066 9.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626-.255.207-.496.404-.691.599C11.029 13.156 11 14.215 11 14.333V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182C15.934 7.765 14.169 6 12 6zM11 16H13V18H11z"></path>
                            <path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8s3.589-8,8-8 s8,3.589,8,8S16.411,20,12,20z"></path>
                        </svg>
                    </a>
                </div>
                <input class="param" type="text" id="font" name="font" alt="Font name" placeholder="Fira Code" value="Fira Code" pattern="^[A-Za-z0-9\- ]*$" title="Font from Google Fonts. Only letters, numbers, and spaces.">

                <label for="weight">Font weight</label>
                <input class="param" type="number" id="weight" name="weight" alt="Font weight" placeholder="400" value="400" min="100" max="900" step="100">

                <label for="size">Font size</label>
                <input class="param" type="number" id="size" name="size" alt="Font size" placeholder="20" value="20">

                <div class="label-group">
                    <label for="letterSpacing">Letter spacing</label>
                    <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/letter-spacing" target="_blank" class="icon tooltip" title="Enter any css value for the letter-spacing property">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6C9.831 6 8.066 7.765 8.066 9.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626-.255.207-.496.404-.691.599C11.029 13.156 11 14.215 11 14.333V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182C15.934 7.765 14.169 6 12 6zM11 16H13V18H11z"></path>
                            <path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8s3.589-8,8-8 s8,3.589,8,8S16.411,20,12,20z"></path>
                        </svg>
                    </a>
                </div>
                <input class="param" type="text" id="letterSpacing" name="letterSpacing" alt="Letter spacing" placeholder="normal" value="normal">

                <label for="duration">Duration (ms per line)</label>
                <input class="param" type="number" id="duration" name="duration" alt="Print duration (ms)" placeholder="5000" value="5000">

                <label for="pause">Pause (ms after line)</label>
                <input class="param" type="number" id="pause" name="pause" alt="Pause duration (ms)" placeholder="1000" value="1000">

                <label for="color">Font color</label>
                <input class="param jscolor jscolor-active" id="color" name="color" alt="Font color" data-jscolor="{ format: 'hexa' }" value="#36BCF7">

                <label for="background">Background color</label>
                <input class="param jscolor jscolor-active" id="background" name="background" alt="Background color" data-jscolor="{ format: 'hexa' }" value="#00000000">

                <label for="center">Horizontally Centered</label>
                <select class="param" id="center" name="center" alt="Horizontally Centered">
                    <option>false</option>
                    <option>true</option>
                </select>

                <label for="vCenter">Vertically Centered</label>
                <select class="param" id="vCenter" name="vCenter" alt="Vertically Centered">
                    <option>false</option>
                    <option>true</option>
                </select>

                <label for="multiline">Multiline</label>
                <select class="param" id="multiline" name="multiline" alt="Multiline">
                    <option value="false">Type sentences on one line</option>
                    <option value="true">Each sentence on a new line</option>
                </select>

                <label for="repeat">Repeat</label>
                <select class="param" id="repeat" name="repeat" alt="Repeat">
                    <option>true</option>
                    <option>false</option>
                </select>

                <label for="random">Random</label>
                <select class="param" id="random" name="random" alt="Random">
                    <option>false</option>
                    <option>true</option>
                </select>

                <label for="dimensions" title="Width ✕ Height">Width ✕ Height</label>
                <span id="dimensions">
                    <input class="param inline" type="number" id="width" name="width" alt="Width (px)" placeholder="435" value="435">
                    <label>✕</label>
                    <input class="param inline" type="number" id="height" name="height" alt="Height (px)" placeholder="50" value="50">
                </span>

                <input type="button" class="btn" value="Reset" onclick="preview.reset();">

                <input type="button" class="btn" value="Open Permalink" onclick="preview.openPermalink();">
            </form>
        </div>

        <div class="output top-bottom-split">
            <div class="top">
                <h2>Preview</h2>

                <img alt="Readme Typing SVG" src="/?lines=The+five+boxing+wizards+jump+quickly" onload="this.classList.remove('loading')" onerror="this.classList.remove('loading')" />
                <div class="loader">Loading...</div>

                <label class="show-border">
                    <input type="checkbox">
                    Show border
                </label>

                <div>
                    <h2>Markdown</h2>
                    <div class="code-container md">
                        <code></code>
                    </div>

                    <button class="copy-button btn tooltip" onclick="clipboard.copy(this);" onmouseout="tooltip.reset(this);" disabled>
                        Copy To Clipboard
                    </button>
                </div>

                <div>
                    <h2>HTML</h2>
                    <div class="code-container html">
                        <code></code>
                    </div>

                    <button class="copy-button btn tooltip" onclick="clipboard.copy(this);" onmouseout="tooltip.reset(this);" disabled>
                        Copy To Clipboard
                    </button>
                </div>
            </div>
            <div class="bottom">
                <a href="https://github.com/DenverCoder1/readme-typing-svg/blob/main/docs/faq.md" target="_blank" class="underline-hover faq">
                    Frequently Asked Questions
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v9l-3.794-3.793-5.999 6-1.414-1.414 5.999-6L12 3h9z"></path>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <a href="javascript:toggleTheme()" class="darkmode" title="toggle dark mode">
        <i class="<?= isset($_COOKIE["darkmode"]) && $_COOKIE["darkmode"] == "on" ? "gg-sun" : "gg-moon" ?>"></i>
    </a>
</body>

</html>