// const { init } = require("./started");

const GAME_TIMER_LIMIT = { goes: 90, normal: 60, hard: 45, god: 30 };

const startedCover = document.getElementById("started");
const summaryCover = document.getElementById("summary");

const startedButton = startedCover.getElementsByTagName("button")[0];
const tryAgainButton = summaryCover.getElementsByTagName("button")[0];

let gameTimerManager = null;

// Display
const timerDisplay = document.getElementById("timer.display");
const scoreDisplaySummary = document.getElementById("score.display.summary");

startedButton.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("On Clicked Started Button Work!");

    startedCover.style.opacity = 0;
    startedCover.style.transition = "opacity 0.75s ease-in-out";

    setTimeout(() => {
        startedCover.style.display = 'none';
        startedContent();
    }, 750);
});

const startedContent = () => {
    init();

    setTimeout(() => {
        startTimer(GAME_TIMER_LIMIT.normal);
        // startTimer(3);
    }, 750);
};

const startTimer = (duration) => {
    let timer = duration;
    timerDisplay.textContent = timer;

    if (gameTimerManager) {
        clearInterval(gameTimerManager);
    }

    gameTimerManager = setInterval(() => {
        timer--;
        timerDisplay.textContent = timer;

        if (timer <= 0) {
            clearInterval(gameTimerManager);
            timerDisplay.textContent = "60";

            summaryCover.style.display = "flex";
            summaryCover.style.opacity = 1;

            scoreDisplaySummary.textContent = score;

            onTryAgain();
        }
    }, 1000);
};

const onTryAgain = () => {
    destroy();

    tryAgainButton.removeEventListener("click", tryAgainHandler);
    tryAgainButton.addEventListener("click", tryAgainHandler);
};

const tryAgainHandler = (e) => {
    e.preventDefault();
    console.log("On Clicked Try Again Button Work!");

    summaryCover.style.opacity = 0;
    summaryCover.style.transition = "opacity 0.75s ease-in-out";

    setTimeout(() => {
        summaryCover.style.display = 'none';
        startedContent();
    }, 750);
};