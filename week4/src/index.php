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
        const words = ["Hello", "Good"];

        const getRandomWord = () => {
            return words[Math.floor(Math.random() * words.length)];
        };

        let currentWord = getRandomWord();
        let currentWordIndex = 0;

        const init = () => {
            console.log("On init...");
            createContent();
            setupWordValidator();
        };

        const createContent = () => {
            const content = document.getElementById("content");
            content.innerHTML = '';

            currentWord.split('').forEach((char, index) => {
                const wordElement = document.createElement("p");
                wordElement.classList.add("word.sleep");

                if (index === 0) {
                    wordElement.classList.add("word.current");
                }

                wordElement.textContent = char;
                content.appendChild(wordElement);
            });
        };

        const setupWordValidator = () => {
            window.addEventListener("keydown", handleKeyPress);
        };

        const handleKeyPress = (e) => {
            // console.log("Handle key press: ", e.key);

            if (e.key === 'Shift') return;

            const currentCharAt = document.getElementsByClassName('word.sleep')[0]

            if (!currentCharAt) return;

            if (currentWord[currentWordIndex] === e.key) {
                currentCharAt.classList.replace("word.sleep", "word.active");
                currentCharAt.classList.add("word.current");
                
                
                if (currentWordIndex > 0) {
                    const prevCharAt = document.getElementsByClassName('word.active')[currentWordIndex - 1];
                    prevCharAt.classList.remove("word.current");

                }

                currentWordIndex++;
            } else {
                currentCharAt.classList.add("word.danger");

            }

            if (currentWordIndex >= currentWord.length) {
                currentWordIndex = 0;
                currentWord = getRandomWord();
                createContent();
            }
        };

        init();
    </script>
</body>

</html>