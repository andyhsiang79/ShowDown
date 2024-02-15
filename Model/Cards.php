<?php
/**
 * suit
 * 黑桃 : 3 : spade
 * 紅心 : 2 : heart
 * 方塊 : 1 : diamond
 * 梅花 : 0 : club
 * rank
 * 2, 3, 4, 5, 6, 7, 8, 9, 10, 11:J, 12:Q, 13:K, 14:A
 */
namespace Model;
class Cards {
    //private $allCards;
    private $suit;
    private $rank;
    private $name;
    //private $allSuit = 4;
    //private $allRank = 13;
    
    public function __construct($suit, $rank) {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->cardNameTranslate();
    }

    public function getSuit(){
        return $this->suit;
    }

    public function getRank(){
        return $this->rank;
    }

    public function getName(){
        return $this->name;
    }

    public static function judgeBigger($cardArr) {
        return 1;
    }

    public function cardNameTranslate() {
        $suitCode = $this->suit;
        $rankCode = $this->rank;
        switch($suitCode) {
            case 3: $suit = "黑桃"; break;
            case 2: $suit = "紅心"; break;
            case 1: $suit = "方塊"; break;
            case 0: $suit = "梅花"; break;
        }
        switch($rankCode) {
            case 2: case 3: case 4: case 5: case 6: case 7: case 8: case 9: case 10: 
                $rank = $rankCode;
                break;
            case 11: $rank = "J"; break;
            case 12: $rank = "Q"; break;
            case 13: $rank = "K"; break;
            case 14: $rank = "A"; break;
        }
        $this->name = $suit." ".$rank;
    }

    public function sortCard($cards) {
        sort($cards);
        return $cards;
    }
}