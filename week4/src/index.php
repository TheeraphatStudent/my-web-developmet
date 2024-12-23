<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Typing</title>
    <link rel="stylesheet" href="../src/style/global.css">
</head>

<body>

    <div class="container.main">
        <div id="content">
        </div>
    </div>

    <?php
    // echo "<h1>Hello World</h1>";

    ?>

    <script>
        const words = ["Hello", "Good"]

        let getWord = words[Math.floor(Math.random() * words.length)]
        console.log(getWord);

        window.addEventListener("keydown", (e) => {
            console.log(e.key);

        });

        let content = document.getElementById("content");

        for (let i = 0; i < getWord.length; i++) {
            const word = document.createElement("p");
            word.classList.add("word.sleep");

            word.textContent = getWord[i];
            content.appendChild(word);

        }


    </script>
</body>

</html>