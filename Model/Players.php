<?php
namespace Model;
abstract class Players {
    protected $id, $name='', $type, $point=0;
    protected $hand = [];
    protected $hasExchangeHand = false;
    protected $exchangeHandEvent = null;
    
    //const PLAYER_TYPE = 1;
    protected const PLAYER_TYPE_HUMAN = 1;
    protected const PLAYER_TYPE_AI = 2;

    //TODO : Human input command, AI random
    abstract public function takeATurn();

    /* TODO : 
        if 有手牌
            顯示手牌
            選出牌
        else
            顯示錯誤訊息
    */
    abstract public function show();

    /*TODO : 
        if 擁有權力(未交換過)
            選要交換手牌玩家(排除自己)
            交換
            開始倒數
            註記交換
        else
            顯示錯誤訊息
    */
    abstract public function exchangeHand();

    public function doExchangeHandEvent($sourcePlayer, $targetPlayer) {
        $this->setHasExchangeHand();
        $this->exchangeHandEvent = new ExchangeHand($sourcePlayer, $targetPlayer);
        $this->exchangeHandEvent->exchange();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
        //echo "設定完成 : {$this->name}";
    }

    public function getName() {
        return $this->name;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setHand($cards) {
        $this->hand = $cards;
    }

    public function getHand() {
        return $this->hand;
    }

    public function gainPoint() {
        $this->point += 1;
    }

    public function getPoint() {
        return $this->point;
    }

    public function setHasExchangeHand() {
        $this->hasExchangeHand = true;
    }

    public function getHasExchangeHand() {
        return $this->hasExchangeHand;
    }
    
    public function isHandEmpty() {
        if(!empty($this->hand)) return true;
        return false;
    }

    protected function hasCard() {
        if(empty($this->hand)) return false;
        return true;
    }
    
    protected function showHandCard($index) {
        $showCard = $this->hand[$index];
        unset($this->hand[$index]);
        $this->hand = array_values($this->hand);
        return $showCard;
    }
}