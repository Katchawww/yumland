function toggleBananaMode() {
    document.body.classList.toggle("banana-mode");

    if(document.body.classList.contains("banana-mode")){
        alert("🍌 BANANA MODE ACTIVÉ !");
        startBananaGame();
    }
    else {
        alert("🍌 BANANA MODE DÉSACTIVÉ !");
        stopBananaGame();
    }
}



let score = 0;
let gameInterval;
let scoreBoard;

function startBananaGame() {
    score = 0;

    // création scoreboard
    scoreBoard = document.createElement("div");
    scoreBoard.id = "scoreBoard";
    scoreBoard.textContent = "🍌 Score : 0";

    scoreBoard.style.position = "fixed";
    scoreBoard.style.top = "10px";
    scoreBoard.style.right = "10px";
    scoreBoard.style.background = "#fff";
    scoreBoard.style.padding = "10px";
    scoreBoard.style.borderRadius = "10px";
    scoreBoard.style.zIndex = "99999";

    document.body.appendChild(scoreBoard);

    // spawn bananes
    gameInterval = setInterval(spawnBanana, 600);
}

function spawnBanana() {
    const banana = document.createElement("div");
    banana.textContent = "🍌";

    banana.style.position = "fixed";
    banana.style.left = Math.random() * window.innerWidth + "px";
    banana.style.top = "-30px";
    banana.style.fontSize = "30px";
    banana.style.cursor = "pointer";
    banana.style.zIndex = "9999";

    document.body.appendChild(banana);

    let pos = -30;

    const fall = setInterval(() => {
        pos += 2;
        banana.style.top = pos + "px";

        if (pos > window.innerHeight) {
            banana.remove();
            clearInterval(fall);
        }
    }, 20);

    // clic = score
    banana.addEventListener("click", () => {
        score += 1;
        scoreBoard.textContent = "🍌 Score : " + score;
        banana.remove();
        clearInterval(fall);
    });
}

function stopBananaGame() {
    clearInterval(gameInterval);
    if (scoreBoard) scoreBoard.remove();
}