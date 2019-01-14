<?php

namespace App\Controllers;

use Bootstrap\Render;
use \App\Models\Deck;

/**
* Index Class is responsible to controller the pages:
*  /, /draft and /success
*/
class Index extends Render
{

    private $message;

    /**
    * Returns the message.
    *
    * @return string message String that must be shown.
    */
    public function getMessage()
    {
        return $this->message;
    }

    /**
    * Sets the message.
    *
    * @param string $message.
    */
    private function setMessage($message)
    {
        $this->message = $message;
    }

    /**
    * Sets the shuffled deck in a PHP Session.
    *
    * @param array $deck Array containing the deck.
    */
    public function setShuffleDeck($deck)
    {
        $_SESSION['shuffle_deck'] = $deck;
    }

    /**
    * Returns the shuffled deck from the PHP Session.
    *
    * @return array shuffled deck.
    */
    private function getShuffleDeck()
    {
        return $_SESSION['shuffle_deck'];
    }

    /**
    * Returns the percentage of chance to succeed.
    *
    * @return float Number of percentage with 2 decimals.
    */
    private function getPercentage()
    {
        return number_format(((1 / count($this->getShuffleDeck())) * 100), 2);
    }

    /**
    * Method responsible to set and render values for the home page.
    */
    public function index()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffleDeck();

        $this->view->suits = $deck->getSuits();
        $this->view->values = $deck->getValues();

        // Set shuffled deck.
        $this->view->shuffle_deck = $deck->getShuffleDeck();
        $this->setShuffleDeck($deck->getShuffleDeck());

        $this->render('index');
    }

    /**
    * Method responsible to calculate the chance and render draft page.
    *
    * If the next card is not equal to selected card by the user, then display a
    *   message with the hit chance percentage.
    * Else redirect to the success page.
    */
    public function draft()
    {
        $message = 'You should select a suit and a card rank.';
        $this->setMessage($message);

        if (count($_POST) > 0) {
            $this->view->selected_card = $_POST['suit'] . $_POST['value'];
            $this->view->suit = $_POST['suit'];
            $this->view->value = $_POST['value'];

            $deck = $this->getShuffleDeck();
            if ($this->view->selected_card != current($deck)) {
                array_shift($deck);
                $this->setShuffleDeck($deck);

                $message = 'Your chance is: ' . $this->getPercentage() . '%';
                $message .= '<br>Now your chance is 1 in ' . count($this->getShuffleDeck());
                $this->setMessage($message);
            } else {
                header("Location: /success");
                return true;
            }
        }

        $this->view->chance = $this->getMessage();
        $this->render('draft');
    }

    /**
    * Method responsible to render in which chance the user succeeded.
    */
    public function success()
    {
        $message = 'Got it, the chance was: ' . $this->getPercentage() . '%';
        $this->setMessage($message);

        $this->view->chance = $this->getMessage();
        $this->render('success');
    }
}
