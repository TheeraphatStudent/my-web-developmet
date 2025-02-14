const toolTip = document.getElementsByClassName("tooltip.minimum")[0];
const scoreDisplay = document.getElementById("score.display");
const incorrectDisplay = document.getElementById("incorrect.display");

const input = document.getElementById('keyboard-trigger');

const words = [
    "Hello", "Goodbye", "Please", "Thank", "You", "Sorry", "Yes", "No", "Help", "Friend",
    "Family", "Food", "Water", "Drink", "Eat", "House", "Home", "School", "Work", "Play",
    "Walk", "Run", "Jump", "Read", "Write", "Book", "Pen", "Paper", "Happy", "Sad",
    "Angry", "Excited", "Love", "Hate", "Big", "Small", "Good", "Bad", "Hot", "Cold",
    "Day", "Night", "Morning", "Evening", "Today", "Tomorrow", "Yesterday", "Now", "Later", "Soon",
    "Dog", "Cat", "Bird", "Fish", "Car", "Bus", "Train", "Airplane", "Bike", "Road",
    "Street", "Park", "City", "Town", "Country", "Beach", "Mountain", "River", "Ocean", "Tree",
    "Flower", "Rain", "Sun", "Moon", "Star", "Sky", "Cloud", "Wind", "Snow", "Fire",
    "Earth", "World", "People", "Child", "Parent", "Brother", "Sister", "Baby", "Man", "Woman",
    "Old", "Young", "Fast", "Slow", "Clean", "Dirty", "Full", "Empty", "Open", "Close"
]

const getRandomWord = () => {
    return words[Math.floor(Math.random() * words.length)];
};

let currentWord = getRandomWord();
let currentWordIndex = 0;
let count_incorrect = 0;
let score = 0;

let tooltipTimer = null;

const elementTimer = (element, duration) => {
    setTimeout(() => {
        element;
    }, duration);
};

const init = () => {
    console.log("On initialize...");
    createContent();
    setupWordValidator();

    input.focus();
};

const destroy = () => {
    console.log("On Destroying...");
    window.removeEventListener("keydown", handleKeyPress);
    tooltipTimer = null;
    score = 0;
    scoreDisplay.textContent = score;

    input.blur()

};

const createContent = () => {
    const content = document.getElementById("content");
    content.innerHTML = '';

    // N i g h t
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
};

const handleKeyPress = (e) => {

    console.group("================ Handle key press ================");
    console.log(e);
    console.log(e.key);
    console.log(currentWord[currentWordIndex]);
    console.groupEnd()

    if (keyChecker(e.code) || keyChecker(e.key)) return;

    const currentCharAt = document.getElementsByClassName('word.sleep')[0];
    if (!currentCharAt) return;

    if (tooltipTimer) {
        clearTimeout(tooltipTimer);
    }

    const currentPosition = currentCharAt.getBoundingClientRect();
    toolTip.style.top = `${currentPosition.y - 20}px`;
    toolTip.style.left = `${currentPosition.x}px`;

    // N i g h t
    // N = N -> true
    // 0 1 2 3 4

    const currentChar = currentWord[currentWordIndex]

    if (currentChar === e.key) {
        currentCharAt.classList.replace("word.sleep", "word.active");
        currentCharAt.classList.add("word.current");

        if (currentWordIndex > 0) {
            const prevCharAt = document.getElementsByClassName('word.active')[currentWordIndex - 1];
            prevCharAt.classList.remove("word.current");
        }

        toolTip.style.opacity = 1;
        toolTip.textContent = `Good!`;

        currentWordIndex++;
    } 
    
    if (currentChar !== e.key) {
        console.log("Not Correct")

        count_incorrect++;

        currentCharAt.classList.add("word.danger");

        toolTip.style.opacity = 1;
        toolTip.textContent = `Incorrect ):`;

        console.log(currentPosition.y + 10, currentPosition.x);

        if (count_incorrect >= 2) {
            console.log("Random Work!")

            if (score > 0) {
                score--
                scoreDisplay.textContent = score

            }

            currentWordIndex = 0;

            currentWord = getRandomWord();
            createContent();

            count_incorrect = 0;

        }

        incorrectDisplay.textContent = count_incorrect
    }

    if (currentWordIndex >= currentWord.length) {
        currentWordIndex = 0;

        currentWord = getRandomWord();
        createContent();

        toolTip.style.opacity = 1;
        toolTip.textContent = `Nice!! +1`;

        score++;
        scoreDisplay.textContent = score

        count_incorrect = 0;
        incorrectDisplay.textContent = count_incorrect
    }

    tooltipTimer = setTimeout(() => {
        toolTip.style.opacity = 0;
    }, 800);
};

// init();
