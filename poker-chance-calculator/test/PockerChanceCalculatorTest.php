<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use \App\Controllers\Index;
use \App\Models\Deck;

/**
 * Test Deck model and Index controller.
 */
class PockerChanceCalculatorTest extends TestCase
{

    // Max cards available in the deck without jokers.
    const MAX_CARDS_IN_DECK = 52;

    /**
     * Test if deck contain 52 cards.
     */
    public function testDeckShouldContain52Cards()
    {
        $deck = new Deck();
        $deck->createDeck();

        $this->assertEquals(MAX_CARDS_IN_DECK, count($deck->getDeck()));
    }

    /**
     * Test if deck was not shuffled.
     */
    public function testDeckShouldNotBeShuffled()
    {
        $deck = new Deck();
        $deck->createDeck();

        $test_deck = [];
        foreach ($deck->getSuits() as $suit) {
            foreach ($deck->getValues() as $value) {
                $test_deck[] = $suit . $value;
            }
        }

        $this->assertEquals($test_deck, $deck->getDeck());
    }

    /**
     * Test if shuffled deck contain 52 cards.
     */
    public function testShuffledDeckShouldContain52Cards()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffleDeck();

        $this->assertEquals(MAX_CARDS_IN_DECK, count($deck->getShuffleDeck()));
    }

    /**
     * Test if deck really shuffled.
     */
    public function testDeckShouldBeShuffled()
    {
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffleDeck();

        $this->assertNotEquals($deck->getDeck(), $deck->getShuffleDeck());
    }

    /**
     * Make sure if PHP Session was set.
     */
    public function testShouldSetSessionWithShuffledDeck()
    {
        $index = new Index();
        $index->index();

        $this->assertTrue(isset($_SESSION['shuffle_deck']));
        $this->assertInternalType('array', $_SESSION['shuffle_deck']);
    }

    /**
     * User can not access directly draft page.
     */
    public function testUserAccessingDraftPageWithoutSelectCard()
    {
        $index = new Index();
        $index->index();
        $index->draft();

        $this->assertEquals('You should select a suit and a card rank.', $index->getMessage());
    }

    /**
     * Make sure if user selected a card.
     */
    public function testUserSelectCard()
    {
        $_POST['suit'] = 'H';
        $_POST['value'] = 'L'; // Fake card, just to make sure you not hit in the first chance.

        $index = new Index();
        $index->index();
        $index->draft();

        $this->assertNotEquals('You should select a suit and a card rank.', $index->getMessage());
    }

    /**
     * When the user has 2 cards in the deck, the chance to succeed is 50%
     */
    public function test50PercentChance()
    {
        $index = new Index();
        $index->setShuffleDeck(['HA', 'H2']);
        $index->success();

        $this->assertEquals('Got it, the chance was: 50.00%', $index->getMessage());
    }

    /**
     * When the user has 1 card in the deck, the chance to succeed is 100%
     */
    public function test100PercentChance()
    {
        $index = new Index();
        $index->setShuffleDeck(['HA']);
        $index->success();

        $this->assertEquals('Got it, the chance was: 100.00%', $index->getMessage());
    }
}
