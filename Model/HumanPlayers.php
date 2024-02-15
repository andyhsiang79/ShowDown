<?php
namespace Model;
use Cards;
//use ExchangeHand;
class HumanPlayers extends Players {

    public function __construct($id) {
        $this->setId($id);
        $this->setType(1);
    }

    public function takeATurn() {
        echo $this->getName().": \n";

        if($this->exchangeHandEvent !== null) {
            $this->exchangeHandEvent->roundCountdown();
        }

        $str = "選擇操作: 1.出牌" . ((!$this->hasExchangeHand) ? "，2.交換手牌" : "");
        echo $str.": ";
        INPUT_TAKETURN:
        $userInput = readInput();
        if(!filter_var($userInput, FILTER_VALIDATE_INT)) {
            echo "僅限輸入數字，請重新輸入: ";
            goto INPUT_TAKETURN;
        }
        if($userInput == '' || $userInput > 2 || ($userInput == 2 && $this->hasExchangeHand)) {
            echo "輸入錯誤，請重新輸入: ";
            goto INPUT_TAKETURN;
        }
        return $userInput;
    }

    public function show() {
        if(!$this->hasCard()) {
            //var_dump($this->hand);
            echo "手上沒牌，不用出\n";
            return '';
        }
        foreach($this->hand as $card) {
            $newHand[] = $card->getName();
        }
        print_r($newHand);
        echo "選擇出牌:";
        INPUT_SHOWCARD:
        $userInput = readInput();
        if($userInput >= count($newHand) || empty($newHand[$userInput])) {
            echo "輸入錯誤，請重新輸入: ";
            goto INPUT_SHOWCARD;
        }
        return $this->showHandCard($userInput);
    }

    public function exchangeHand() {
        if($this->hasExchangeHand) {
            return false;
        }

        echo "輸入目標玩家編號(輸入0取消): ";
        INPUT_EXCHANGEHAND:
        $userInput = readInput();
        if($userInput != $this->id && $userInput <= 4) {
            return $userInput;
        } else {
            echo "輸入錯誤，請重新輸入: ";
            goto INPUT_EXCHANGEHAND;
        }
    }
}