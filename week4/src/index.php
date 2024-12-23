<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Typing</title>
    <link rel="stylesheet" href="../src/style/global.css">
</head>

<body>
    <span class="tooltip.minimum"></span>
    <div class="cover bg.glass" id="started">
        <button class="btn.simple" type="button">Start</button>

    </div>

    <div class="cover bg.glass flex flex-col" style="gap: 5rem; opacity: 0; display: none;" id="summary">
        <span style="font-size: 4.5rem; color: var(--color-white); max-width: 800px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
            <span>Score: <span class="score.display">0</span></span>
        </span>

        <button class="btn.simple" type="button">Try Again?</button>

    </div>

    <div class="container.main">
        <div class="container.childe items.around">
            <span>Timer: <span id="timer.display">60</span> Second</span>
            <span>Score: <span class="score.display">0</span></span>
        </div>
        <div class="container.childe">
            <div id="content">
                <p>...</p>
            </div>
        </div>
        <button class="btn.highlight" type="button" onclick="">Give Up?</button>
    </div>

    <?php
    // echo "<h1>Hello World</h1>";

    ?>

    <script src="../src/script/display.js"></script>
    <script src="../src/script/manager.js"></script>
    <script src="../src/script/started.js"></script>

</body>

</html>