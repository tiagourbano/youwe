<?php

namespace App\Models;

class Deck {
  
  private $suits;
  private $values;
  private $deck;
  private $shuffle_deck;

  public function __construct() {
    $this->suits = ['H', 'S', 'D', 'C'];
    $this->values = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'];
  }

  public function createDeck() {
    foreach ($this->suits as $suit) {
      foreach ($this->values as $value) {
        $this->deck[] = $suit . $value;
      }
    }
  }

  public function shuffleDeck() {
    $this->shuffle_deck = $this->deck;
    shuffle($this->shuffle_deck);
  }

  public function getDeck() {
    return $this->deck;
  }

  public function getShuffleDeck() {
    return $this->shuffle_deck;
  }

  public function getSuits() {
    return $this->suits;
  }
  
  public function getValues() {
    return $this->values;
  }
  
}
