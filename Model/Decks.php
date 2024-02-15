<?php
namespace Model;
class Decks {
    private $origenDeck = [];
    private $newDeck = [];

    public function __construct() {
        $this->setOrigenDeck();
    }

    private function setOrigenDeck() {
        for($i=0; $i<4; $i++) {
            for($j=2; $j<=14; $j++) {
                $this->origenDeck[] = new Cards($i, $j);
            }
        }
        //var_dump($origenDeck);
    }

    public function getOrigenDeck() {
        return $this->origenDeck;
    }

    public function beShuffled() {
        $this->newDeck = $this->origenDeck;
        shuffle($this->newDeck);
    }

    public function getNewDeck() {
        return $this->newDeck;
    }

    public function drawCard() {
        //draw card to 4 people
        $hand1 = $hand2 = $hand3 = $hand4 = [];
        for($i = 0; $i < count($this->newDeck); $i+=4) {
            $hand1[] = $this->newDeck[$i];
            $hand2[] = $this->newDeck[$i+1];
            $hand3[] = $this->newDeck[$i+2];
            $hand4[] = $this->newDeck[$i+3];
            
        }
        sort($hand1);sort($hand2);sort($hand3);sort($hand4);
        return [
            1=>$hand1,
            2=>$hand2,
            3=>$hand3,
            4=>$hand4,
        ];

        //draw card to any people, 1 card/per
        /*if(!empty($this->newDeck)) {
            $card = array_shift($this->newDeck);
            return $card;
        } else {
            return false;
        }*/
    }
}