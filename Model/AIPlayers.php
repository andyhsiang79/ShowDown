<?php
namespace Model;
class AIPlayers extends Players {

    public function __construct($id) {
        $this->setId($id);
        $this->setType(2);
    }

    public function takeATurn() {
        echo $this->getName().": \n";

        if($this->exchangeHandEvent !== null) {
            $this->exchangeHandEvent->roundCountdown();
        }

        $str = "選擇操作: 1.出牌" . ((!$this->hasExchangeHand) ? "，2.交換手牌" : "");
        echo $str.": ";
        $randMax = ($this->hasExchangeHand === false) ? 2 : 1;
        $randomCommand = rand(1, $randMax);
        echo $randomCommand."\n";
        //$randomCommand = 1;

        return $randomCommand;
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
        $userInput = rand(0, count($this->hand)-1);
        /*if($userInput >= count($newHand) || empty($newHand[$userInput])) {
            echo "輸入錯誤，請重新輸入!\n";
            goto INPUT_SHOWCARD;
        }*/
        return $this->showHandCard($userInput);
    }

    public function exchangeHand() {
        if($this->hasExchangeHand) {
            return false;
        }

        echo "輸入目標玩家編號: ";
        INPUT_EXCHANGEHAND:
        $userInput = rand(1, 4);
        if($userInput != $this->id && $userInput <= 4) {
            return $userInput;
        } else {
            goto INPUT_EXCHANGEHAND;
        }
    }
}