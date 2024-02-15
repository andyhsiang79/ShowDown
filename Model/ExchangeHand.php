<?php
namespace Model;
class ExchangeHand {
    private $status = 0;//0:null, 1:running, 2:over
    private $sourcePlayer;
    private $targetPlayer;
    private $exchangeRoundCountdown = 4;

    public function __construct($sourcePlayer, $targetPlayer) {
        $this->setPlayers($sourcePlayer, $targetPlayer);
    }
    
    private function setPlayers($sourcePlayer, $targetPlayer) {
        $this->sourcePlayer = $sourcePlayer;
        $this->targetPlayer = $targetPlayer;
    }

    public function getSourcePlayer() {
        return $this->sourcePlayer;
    }

    public function getTargetPlayer() {
        return $this->targetPlayer;
    }

    public function exchange() {
        if($this->status == 0) $this->status = 1;
        echo "手牌交換 {$this->sourcePlayer->getName()} <==> {$this->targetPlayer->getName()}\n";
        $tmpHand = $this->sourcePlayer->getHand();
        $this->sourcePlayer->setHand($this->targetPlayer->getHand());
        $this->targetPlayer->setHand($tmpHand);
        $this->roundCountdown();
    }

    public function roundCountdown() {
        if($this->status == 1) {
            $this->exchangeRoundCountdown--;
            echo "倒計時 {$this->exchangeRoundCountdown} 回合\n";
            if($this->exchangeRoundCountdown == 0) {
                $this->status = 2;
                $this->exchange();
            }
        }
    }
}