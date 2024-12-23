const words = ["Hello", "Good"];

const getRandomWord = () => {
    return words[Math.floor(Math.random() * words.length)];
};

let currentWord = getRandomWord();
let currentWordIndex = 0;
let score = 0

let tooltipTimer = null;

const elementTimer = (element, duration) => {
    setTimeout(() => {
        element

    }, duration)

}

const init = () => {
    console.log("On initialize...");
    createContent();
    setupWordValidator();
};

const destroy = () => {
    console.log("On Destroying...")
    window.removeEventListener("keydown", handleKeyPress);
    tooltipTimer = null
    score = 0

}

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

const keyChecker = (key) => {
    const ignoredKeys = ['Shift', 'Control', 'Tab', 'Space', 'CapsLock'];
    return ignoredKeys.includes(key) || key === undefined;
}

const handleKeyPress = (e) => {
    console.log("Handle key press: ", e.key);
    console.log(e);

    if (keyChecker(e.code) || keyChecker(e.key)) return;

    const currentCharAt = document.getElementsByClassName('word.sleep')[0];
    if (!currentCharAt) return;

    const toolTip = document.getElementsByClassName("tooltip.minimum")[0];

    if (tooltipTimer) {
        clearTimeout(tooltipTimer);
    }

    const currentPosition = currentCharAt.getBoundingClientRect();
    toolTip.style.top = `${currentPosition.y - 20}px`;
    toolTip.style.left = `${currentPosition.x}px`;

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

        toolTip.style.opacity = 1;
        toolTip.textContent = `Incorrect ):`;
        // toolTip.style.right = `${currentPosition.x}px`;

        console.log(currentPosition.y + 10, currentPosition.x);
    }

    if (currentWordIndex >= currentWord.length) {
        currentWordIndex = 0;
        currentWord = getRandomWord();
        createContent();

        toolTip.style.opacity = 1;
        toolTip.textContent = `Nice!! +1`;

        score++;
        display.score.textContent = score
    }

    tooltipTimer = setTimeout(() => {
        toolTip.style.opacity = 0;
    }, 800);
};

// init();