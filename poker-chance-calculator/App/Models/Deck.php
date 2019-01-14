<?php

namespace App\Models;

/**
 * Deck Class is responsible to model the deck.
 */
class Deck
{

    private $suits;
    private $values;
    private $deck;
    private $shuffle_deck;

    public function __construct()
    {
        $this->setSuits(['H', 'S', 'D', 'C']);
        $this->setValues(['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K']);
    }

    /**
     * Creates and set a deck.
     */
    public function createDeck()
    {
        $deck = [];
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $deck[] = $suit . $value;
            }
        }

        $this->setDeck($deck);
    }

    /**
     * Shuffles the existing deck.
     */
    public function shuffleDeck()
    {
        $shuffle_deck = $this->getDeck();
        shuffle($shuffle_deck);
        $this->setShuffleDeck($shuffle_deck);
    }

    /**
     * Sets a deck.
     *
     * @param array $deck.
     */
    private function setDeck($deck)
    {
        $this->deck = $deck;
    }

    /**
     * Returns an array with deck.
     *
     * @return array deck.
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * Sets shuffle deck.
     *
     * @param array $shuffle_deck.
     */
    private function setShuffleDeck($shuffle_deck)
    {
        $this->shuffle_deck = $shuffle_deck;
    }

    /**
     * Returns an array with shuffled deck.
     *
     * @return array $shuffle_deck.
     */
    public function getShuffleDeck()
    {
        return $this->shuffle_deck;
    }

    /**
     * Sets suits.
     *
     * @param array $suits Array containing the suits of the cards.
     */
    private function setSuits($suits)
    {
        $this->suits = $suits;
    }

    /**
     * Returns an array with the suits.
     *
     * @return array suits.
     */
    public function getSuits()
    {
        return $this->suits;
    }

    /**
     * Set values.
     *
     * @param array $values Array containing the values of the cards.
     */
    private function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * Returns an array with the values.
     *
     * @return array values.
     */
    public function getValues()
    {
        return $this->values;
    }
}
