<?php
namespace Model;

class Game {
    private $playerArr = [];
    private $allRound = 13;
    private $playersShowCard = [];

    public function start() {
        $this->setPlayers();
        $this->play();
    }

    public function setFourHumanPlayers() {
        for($i=1;$i<5;$i++) {
            $player = new HumanPlayers($i);
            $player->setName("player{$i}");
            $this->playerArr[$i] = $player;
        }
    }

    public function setPlayers($playerCount = 0) {
        for($i=1; $i<5; $i++) {
            $inputPlayerType = 1;
            INPUT_PLAYERS_TYPE:
            //echo "第{$i}位玩家(1:真實玩家,2:AI玩家) : ";
            //$inputPlayerType = readInput();
            if($i > $playerCount) {
                $inputPlayerType = 2;
            }
            if($inputPlayerType == 1) {
                $player = new HumanPlayers($i);
            } elseif($inputPlayerType == 2) {
                $player = new AIPlayers($i);
            } else {
                echo "輸入錯誤，請重新輸入!\n";
                goto INPUT_PLAYERS_TYPE;
            }
            echo "設定玩家{$i}名稱 (Enter跳過) : ";
            $inputPlayerName = readInput();
            $inputPlayerName = filter_var($inputPlayerName);
            if($inputPlayerName == '') {
                $inputPlayerName = "玩家{$i}";
            }
            $player->setName($inputPlayerName);
            $this->playerArr[$i] = $player;
        }
        //var_dump($this->playerArr);
    }

    public function setDeck() {
        $deck = new Decks();
        $deck->beShuffled();
        $allHand = $deck->drawCard();
        
        foreach($this->playerArr as $index=>$player) {
            $player->setHand($allHand[$index]);
        }
    }

    public function play() {
        echo "遊戲開始!!\n\n";
        for($i=1; $i<=$this->allRound; $i++) {
            echo "\n\n=====回合開始=====\n\n";
            echo "\n=====Round {$i}=====\n";
            $this->clearPlayersShowCardArr();
            foreach($this->playerArr as $index=>$player) {
                INPUT_PLAYER_TAKE_A_ROUND:
                $userInput = $player->takeATurn();
                if($userInput == 2) {
                    $targetPlayer = $player->exchangeHand();
                    if($targetPlayer === '0') goto INPUT_PLAYER_TAKE_A_ROUND;
                    if($targetPlayer > 0) {
                        $player->doExchangeHandEvent($player, $this->playerArr[$targetPlayer]);
                    } else {
                        echo "輸入錯誤，請重新輸入: ";
                        goto INPUT_PLAYER_TAKE_A_ROUND;
                    }
                }
                if($userInput == 1 || $player->getHasExchangeHand()) {
                    $playerShowCardResult = $player->show();
                    //var_dump($playerShowCardResult);
                } else {
                    echo "輸入錯誤，請重新輸入: ";
                    goto INPUT_PLAYER_TAKE_A_ROUND;
                }
                
                $this->setPlayerShowCard($player->getId(), $playerShowCardResult);
            }
            if(!empty($this->playersShowCard)) {
                $whosCardIsBigger = $this->judgeTheBiggerCard($this->playersShowCard);
                $this->playerArr[$whosCardIsBigger]->gainPoint();
                $this->displayAllShowCard();
                echo $this->playerArr[$whosCardIsBigger]->getName()." 得1分\n\n";
                echo "-----------------\n";
                $this->displayAllPlayerPoint();
                echo "-----------------\n";
            }
            if($i == $this->allRound && $this->checkAllPlayerHands()) {
                $this->allRound++;
            }
        }
        $winner = $this->whosTheWinner();
        $winnerList = implode(',', $winner);
        echo "獲勝者為: {$winnerList}\n";
    }

    private function clearPlayersShowCardArr() {
        $this->playersShowCard = [];
    }

    private function displayAllShowCard() {
        echo "\n";
        foreach($this->playersShowCard as $playerId=>$card) {
            echo $this->playerArr[$playerId]->getName()." : ".(is_object($card) ? $card->getName() : "")."\n";
        }
        echo "\n";
    }
    
    private function setPlayerShowCard($playerId, $playerShowCardResult) {
        $this->playersShowCard[$playerId] = $playerShowCardResult;
    }

    private function judgeTheBiggerCard($cardArr) {
        //var_dump($cardArr);
        $max = [
            'index' => 0,
            'rank' => 0,
            'suit' => 0
        ];
        foreach($cardArr as $idx=>$card) {
            if(empty($card)) continue;
            if($card->getRank() > $max['rank']
                || ($card->getRank() == $max['rank'] && $card->getSuit() == $max['suit'])) {
                $max = [
                    'index' => $idx,
                    'rank' => $card->getRank(),
                    'suit' => $card->getSuit()
                ];
            }
        }
        return $max['index'];
    }

    private function whosTheWinner() {
        $winner = [];
        $maxPoint = 0;
        foreach($this->playerArr as $player) {
            if($player->getPoint() > $maxPoint) {
                $winner = [];
                $maxPoint = $player->getPoint();
                $winner[] = $player->getName();
            } elseif($player->getPoint() == $maxPoint) {
                $winner[] = $player->getName();
            }
        }
        return $winner;
    }

    private function displayAllPlayerPoint() {
        foreach($this->playerArr as $player) {
            echo "|  ";
            echo $player->getName().":".$player->getPoint();
            echo "   |\n";
        }
    }

    private function checkAllPlayerHands() {
        foreach($this->playerArr as $player) {
            if(!empty($player->getHand())) return true;
        }       
    }
}