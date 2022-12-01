function setup() {
    width = document.getElementById('game-container').offsetWidth - 100;
    containerHeight = window.innerHeight;
    height = width * 3 / 4 - width / 6;
    canvas = createCanvas(width, Math.max(height, containerHeight * 3 / 4)); // ~4:3 aspect ratio
    canvas.parent('game-container');

    button = createButton('Submit move');
    button.position(width - 150, height - 50);
    button.parent('game-container');
    button.attribute('class', 'btn btn-success')
    button.mousePressed(nextTurn);
}

var canvas;
var rubiesInBox = [];
var rubiesInBoxP2 = [];
var inGame = false;
var done = false;
var numRubies;
var numStones;
var turn = 0;
var player1Guess = 0;
var player2Guess = 0;
var player1Total = 0;
var player2Total = 0;

var game;
var message = '';

var numberTextSize = 24;

function makeBoxes(numBoxes) {
    for (var i = 0; i < numBoxes; i++) {  
        var img = "<img src ='images/box.drawio.png' id='boxid"+i+"' onclick='updateBox("+i+")' />"; 
        $(".game-box").append(img);
    }
}

function updateBox(boxIndex) {
    // Use the guesses of the players
    let player1Reward = 0;
    let player2Reward = 0;
    if(rubiesInBox[boxIndex] >= player1Guess) {
        player1Reward = player1Guess;
        rubiesInBox[boxIndex] -= player1Guess;
    }
    if(rubiesInBoxP2[boxIndex] >= player2Guess) {
        player2Reward = player2Guess;
        rubiesInBoxP2[boxIndex] -= player2Guess;
    }

    player1Total += player1Reward;
    player2Total += player2Reward;
    
}

function draw() {
    background(220);
    fill(255);
    //rect(20, 200, width-40, 20);
    if(inGame) {
        strokeWeight(0);
        drawMessage();
        drawPlayers();
        if(!tipping) {
            drawTable();
        } else{
            tipBoard();
        }
    }
}

function randomIntFromInterval(min, max) { // min and max included 
    return Math.floor(Math.random() * (max - min + 1) + min)
}

    /*
     * Properties is an object containing all necessary information for game.
     *
     * - numberOfRubies: number of rubies in the game
     * - numberOfBoxes: number of boxes in the game
     * - player1: Gives the name for player 1.
     * - player2: Gives the name for player 2.
     * - time: Amount of time that each player has
     */
function startGame() {
    message = '';
    player1 = document.getElementById("player-1").value;
    player2 = document.getElementById("player-2").value;
    numRubies = document.getElementById("number-of-rubies").value;
    numBoxes = document.getElementById("number-of-boxes").value;

    if(numBoxes < 2) {
            document.getElementById('error-message').innerText = "Number of boxes cannot be lesser than 2";
            document.getElementById('error-container').style.display = 'block';
            inGame = false;
            return;
    }

    if(numRubies < 1) {
        document.getElementById('error-message').innerText = "Number of rubies cannot be lesser than 1";
        document.getElementById('error-container').style.display = 'block';
        inGame = false;
        return;
}

    game = new Game({
        player1: player1,
        player2: player2,
        numberOfBoxes: numBoxes,
        numberOfRubies: numRubies,
        time: 120
    });

    done = false;
    boxRubies = 0;
    totalRubiesUsed = 0;
    rubiesInBox = [];
    rubiesInBoxP2 = [];

    for(var i = 0; i < numBoxes - 1; i++) {
        boxRubies = parseInt((randomIntFromInterval(1, 100) / 100.0) * numRubies);
        rubiesInBox.push(boxRubies);
        rubiesInBoxP2.push(boxRubies);
        totalRubiesUsed = totalRubiesUsed + boxRubies;
    }

    rubiesInBox.push(numRubies - totalRubiesUsed);
    rubiesInBoxP2.push(numRubies - totalRubiesUsed);

    makeBoxes(numBoxes, rubiesInBox);

    inGame = true;
}

function drawTable() {

    var start = 60;
    var length = width - 168;
    fill(0);
    stroke(0);
    var step = length / boardSize;
    rect(start, 3 * height/4, length - step, 3);
    // INDICES FOR TICK MARKS

    for(var i = 0; i < boardSize; ++i) {
        strokeWeight(0);
        var size =1;
        if(selectedTile == i) {
            stroke(0,0,0);
            fill(0,255,0);
            size = 3;
        }else{
            stroke(0,0,0);
        }

        // console.log(i, start + i * step, 3 * height / 4 - 10, size, 20)
        strokeWeight(1);
        if(selectedTile == i) {
            rect(start + i * step - .75, 3 * height / 4 - 10, size, 20);
        } else {
            rect(start + i * step, 3 * height / 4 - 10, size, 20);     // strokeWeight affects the green
        }
        textSize(numberTextSize);
        stroke(0);
        if(i % 5 == 0) {
            strokeWeight(0);
            fill(0);
            text(i - (boardSize / 2), start + i * step, 3 * height / 4 + 60);
            strokeWeight(1);
        }

    }

    strokeWeight(0);
    fill(color('rgba(130, 121, 113, 1)'));
    triangle(start + (boardSize / 2 - 3.0) * step + 1.25, 3 * height / 4, start + (boardSize / 2 - 3.125) * step + 1.25, 3 * height / 4 + 40, start +(boardSize / 2 - 2.875) * step + 1.25, 3 * height / 4 + 40);
    rect(start + (boardSize / 2 - 3.125) * step + 1.25, height, step / 4, - (height / 4) + 40);

    triangle(start + (boardSize / 2 - 1) * step + 1.25, 3 * height / 4, start + (boardSize / 2 - 1.125) * step + 1.25, 3 * height / 4 + 40, start + (boardSize / 2 - .875) * step + 1.25, 3 * height / 4 + 40);
    rect(start + (boardSize / 2 - 1.125) * step + 1.25, height, step / 4, - (height / 4) + 40);
}


function drawPlayers() {
            // Player 1 Text
    textSize(30);
    fill(255,0,0);
    stroke(255,0,0);
    text(player1, width/4, 60);
            // Player 2 Text
    fill(0,0,255);
    stroke(0,0,255);
    text(player2, width -(width/3), 60);
}

function mouseClicked() {
    var start = 10;
    var length = width - 168;
    var step = length/10/2;
    var right = 0;
    var down = 120;
    var half = maxDist /2;
    for(var i = 1; i <= numStones; i++) {
        var x = half + start + right * step;
        x+= extra;
        var y = down-half;
        var dx = x - mouseX;
        if(dx <0) dx = 0 - dx;

        var dy = y - mouseY;
        if(dy <0) dy = 0 - dy;

        if(dx <maxDist && dy < maxDist && turn == 0) {
            selectedWeight = i;
            break;
        }

        right = right + 2;

        if( right >= 10 ) {
            right = 0;
            down = down + 30;
        }
    }

    start = (width/2)+10;
    down = 120;
    right = 0;

    for(var i = 1; i <= numStones; i++) {
        var x = half + start + right * step;
        x+=extra;
        var y = down-half;
        var dx = x - mouseX;
        if(dx < 0) dx = 0 - dx;

        var dy = y - mouseY;
        if(dy < 0) dy = 0 - dy;

        if(dx <maxDist && dy < maxDist && turn ==1) {
            selectedWeight = i;
            break;
        }
        right = right + 2;
        if(right >= 10 ) {
            right = 0;
            down = down + 30;
        }
    }

    start = 60;
    step = length/boardSize;
    for(var i = 0; i < boardSize; ++i) {
        var x = half + start + i * step;
        var y = half + 3 * height/4 -10;
        var dx = mouseX - x;
        var dy = mouseY - y;
        if(dx < 0) dx = 0 - dx;
        if(dy < 0) dy = 0 - dy;

        if(dx < maxDist && dy < maxDist) {
            selectedTile = i;
        }
    }
}

function nextTurn() {
    //logic for next turn
    /* important variables
        turn = current player turn: 0 = player1, 1 = player2
        currentBox = the current box that the current player will guess for
        selectedGuess = the current guess that the current player has chosen
        numRubies = number of rubies
        rubiesInBox = array that tells you the current number of rubies in each box for player 1
        rubiesInBoxP2 = array that tells you the current number of rubies in each box for player 2
    */

    if(done) return;
    // Need way to parse guesses

    if(game.gameState === 'Placing Weights') {
        message = game.placeWeight(Number(selectedWeight), Number(selectedTile) - Number(game.board.boardLength) / 2);
        boardState[selectedTile] = selectedWeight;
        boardColor[selectedTile] = turn+1;
    } else {
        message = game.removeWeight(Number(selectedTile) - Number(game.board.boardLength) / 2);
        boardState[selectedTile] = 0;
    }

    // IN PROD
    if(game.gameOver) {
        gameOver();
	game.gameOver = false;
	done = true;
    }

}

function drawMessage() {
    fill(0,0,0);
    stroke(0,0,0);
    strokeWeight(1);
    textSize(30);
    textAlign(CENTER, CENTER);

    text(message, width / 2, height / 2 - 50);
}

// 'https://cims.nyu.edu/drecco2016/games/NoTipping/saveScore.php'

function gameOver() {
    $.get('https://cims.nyu.edu/~as9913/drecco/games/NoTipping/saveScore.php', {
        score: game.players[turn].name,
        gamename: 'NoTipping',
        playername: game.players[0].name + ' vs ' + game.players[1].name
    }).done(function(data) { 
        console.log("Saved success");
        console.log(data);
    }).fail(function(data) {
        console.log("Saved failure");
        console.log(data);
    });
}

/*
 * Object for the board state. Maintains following information:
 *
 * - numberOfWeights: total number of weights
 * - boardLength: the length of the board
 * - boardWeight: the size of the board
 * - leftTorque, rightTorque: the left and right torque's values.
 * - boardState[i]: An array which stores the weight if there is one at index i.
 */
class Box {

    constructor(numberOfRubies) {
        if(numRubies < 0) {
            throw "Each box needs to have non-negative number of rubies"
        }

        this.currentRubies = numberOfRubies
    }
}

/*
 * Object for the respective player. Contains the following information:
 *
 * - name: Name of the player
 * - timeLeft: Amount of time player has left (unnecessary(?))
 * - numberOfWeights: The total number of weights
 * - containsWeights: An array containing the weights they have available to use
 */
class Player {

    constructor(name, numberOfRubies, timeLeft) {
        this.name = name;
        this.numberOfRubies = numberOfRubies;
        this.timeLeft = timeLeft;
    }
}

class Game {

    /*
     * Properties is an object containing all necessary information for game.
     *
     * - numberOfWeights: number of weights in the game
     * - boardLength: length of the board
     * - boardWeight: the weight of the board
     * - player1: Gives the name for player 1.
     * - player2: Gives the name for player 2.
     * - time: Amount of time that each player has
     */
    constructor(properties) {
        this.numberOfBoxes = properties.numberOfBoxes;
        this.numberOfRubies = properties.numberOfRubies;
        this.totalTime = properties.time;
        this.gameOver = false;
        this.gameState = 'Guessing';
        this.currentTurn = 0;
        this.rubiesGuessed = 0;
        this.rubiesRecieved = 0;

        this.players = new Array(2);
        this.players[0] = new Player(properties.player1, this.numberOfRubies, this.totalTime);
        this.players[1] = new Player(properties.player2, this.numberOfRubies, this.totalTime);

        this.boxes = new Array(this.numberOfBoxes)
        
        // Get box quantities

        this.isGameOver();
    }

    /*
     *  Determines whether the game is over based on left and right torque.
     *
     */
    isGameOver() {
        // initialize with board weight
        // Need game over condition
        gameOver = true
        return gameOver;
    }

    makeGuess(guess) {
        message = this.isValidGuess(guess);
        if(message === '') {
            // do the thing  
        } else {
            this.gameOver = true;
            return message;
        }
    }

    /*
     * Check before guess to see if it is a valid move:
     * - guess must be greater than equal to 0
     */
    isValidGuess(guess) {
        // instead of throwing error, set game to over...
        if(guess < 0) {
            return 'Invalid guess from ' + this.players[this.currentTurn].name;
        }

        return '';
    }

    /*
     * Update the player's time based on the amount of time that they took.
     * (May be unnecessary for 2-player games)
     */
    updateTime(turn, time) {
        this.players[this.currentTurn].timeLeft -= time;

        if(this.players[this.currentTurn].timeLeft <= 0) {
            this.gameOver = true;
            return this.players[this.currentTurn].name + ' ran out of time';
        } else {
            return this.players[this.currentTurn].name + ' has ' + this.players[this.currentTurn].timeLeft + ' time left.';
        }
    }
}
