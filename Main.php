<?php
include('Fun.php');
include_once __DIR__ . "/autoload.php";

if(PHP_SAPI !== "cli") {
    echo "請在cli模式下開啟!";
    exit();
}
$start = false;
do{
    $game = new Model\Game();
    echo "請輸入玩家數量(1-4): ";
    INPUT_PLAYERS_COUNT:
    $userInput = readInput();
    if($userInput < 1 || $userInput > 4) {
        echo "輸入錯誤，請重新輸入: ";
        goto INPUT_PLAYERS_COUNT;
    }
    $game->setPlayers($userInput);
    //$game->setFourHumanPlayers();
    $game->setDeck();
    $game->play();

    echo "是否重新開始遊戲(y/n):";
    $userInput = readInput();
    $userInput = strtoupper($userInput);
    if($userInput === 'Y') {
        $start = true;
    }
} while($start);

exit("遊戲結束!");
