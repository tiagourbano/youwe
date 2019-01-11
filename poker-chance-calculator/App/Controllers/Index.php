<?php

namespace App\Controllers;

use Bootstrap\Render;
use \App\Models\Deck;

class Index extends Render {

  public function index() {

    $deck = new Deck();
    $deck->createDeck();

    $this->view->suits = $deck->getSuits();
    $this->view->values = $deck->getValues();

    // Get all cards in the deck.
    $cards = $deck->getDeck();
    $this->view->cards = $cards;

    // Shuffle deck.
    $deck->shuffleDeck();
    
    // Set shuffled deck.
    $this->view->shuffle_deck = $deck->getShuffleDeck();
    $this->setShuffleDeck($deck->getShuffleDeck());

    $this->render('index');
  }

  public function draft() {
    if (count($_POST) > 0) {
      $this->view->selected_card = $_POST['suit'] . $_POST['value'];
      $this->view->suit = $_POST['suit'];
      $this->view->value = $_POST['value'];
      
      if ($this->view->selected_card != current($_SESSION['shuffle_deck'])) {
        array_shift($_SESSION['shuffle_deck']);
        $this->view->chance = 'Your chance is: ' . number_format(((1 / count($_SESSION['shuffle_deck'])) * 100), 2) . '%';
        $this->view->chance .= '<br>Now your chance is 1 in ' . count($_SESSION['shuffle_deck']);
      }
      else {        
        header("Location: /success");
        exit();
      }
    }
    $this->render('draft');
  }
  
  public function success() {
    $this->view->chance = 'Got it, the chance was: ' . number_format(((1 / count($_SESSION['shuffle_deck'])) * 100), 2) . '%';
    $this->render('success');
  }

  private function setShuffleDeck($deck) {
    $_SESSION['shuffle_deck'] = $deck;
  }

  private function getShuffleDeck() {
    return $_SESSION['shuffle_deck'];
  }
}