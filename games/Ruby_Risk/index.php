<?php
// Filename of your index page
$index = "game.html";
// Metadata
$game = "Ruby Risk";
$team = "Helloworld";
$instruction = <<<EOD
<p> You have <strong> n </strong> (default = 3) covered boxes of Burmese rubies before you  and the total number of rubies is <strong> m </strong> (default = 30). Each of the two players is allowed to ask for a certain number of rubies from each box. There are two possible cases:
    <p> - If the player asks for more than there are in the box, they get none from it </p>
    <p> - Otherwise, you get what you asked for from that box </p>
</p>

<p> We start from the leftmost box and move to the right. Each player gets the chance to enter their guess. Once the guesses for a box are collected, the results of those guesses are displayed. This is done for every box. The winner is determined by whoever has the largest number of rubies at the end of two rounds or until the rubies in each box are exhausted.</p>

<p> <strong> Rules: </strong>
    <p> - No player may ask for rubies greater than the total remaining amount </p>
    <p> - No player may ask for rubies lesser than 1 </p>
</p>

<p> <strong> Instructions </strong>
    <p> - Press pop-up to access game window. </p>
    <p> - ENTERING PHASE: When it is your turn, type your amount in the box. Then click "submit move" to end your turn. </p>
    <p> - DISPLAY PHASE: After all the amounts are collected you will see how many rubies you obtained. </p>
</p>

<p> <strong> Note: </strong> For best experience, maximize window as much as possible. </p>
EOD;

// Size of the popup window
$width = 940;
$height = 1000;
// If your score is sortable, 1 if higher score is better, -1 if smaller score is better, 0 otherwise.
$scoring = 1;

include '../../template.php';
