<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the DeckOfCards class.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Test that a DeckOfCards object can be created.
     */
    public function testCreateDeckOfCards(): void
    {
        $card = new DeckOfCards();
        $this->assertInstanceOf(DeckOfCards::class, $card);
    }

    /**
     * Test that createDeck returns 52 cards.
     */
    public function testCreateDeckReturns52Cards(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->createDeck();
        $this->assertCount(52, $cards);
    }

    /**
     * Test that shuffleCards returns shuffled deck (same size, different order).
     */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();
        $original = $deck->createDeck();
        $shuffled = $deck->shuffleCards();

        $this->assertCount(52, $shuffled);
        $this->assertNotSame($original, $shuffled);
    }

    /**
     * Test that drawCard returns a single Card and deck size decreases.
     */
    public function testDrawCardReducesDeck(): void
    {
        $deck = new DeckOfCards();
        $deck->createDeck();
        $initialCount = $deck->getRemainingCount();
        $card = $deck->drawCard();

        $this->assertInstanceOf(Card::class, $card);
        $this->assertEquals($initialCount - 1, $deck->getRemainingCount());
    }

    /**
     * Test drawing multiple cards reduces deck correctly.
     */
    public function testDrawCardsReducesDeckCorrectly(): void
    {
        $deck = new DeckOfCards();
        $deck->createDeck();
        $cards = $deck->drawCards(5);

        $this->assertCount(5, $cards);
        $this->assertEquals(47, $deck->getRemainingCount());
    }

    /**
     * Test getAsJson returns structured array.
     */
    public function testDeckAsJson(): void
    {
        $deck = new DeckOfCards();
        $deck->createDeck();
        $json = $deck->getAsJson();

        // $this->assertIsArray($json);
        $this->assertCount(52, $json);
        $this->assertArrayHasKey('rank', $json[0]);
        $this->assertArrayHasKey('suit', $json[0]);
    }

    /**
     * Test that getCardAsString returns a string for a single card.
     */
    public function testGetCardAsString(): void
    {
        $deck = new DeckOfCards();
        $deck->createDeck();
        $card = $deck->drawCard();
        if ($card !== null) {
            $result = $deck->getCardAsString($card);
            $this->assertNotEmpty($result);
        }
    }

    /**
     * Test that getAsString returns a string for an array of cards.
     */
    public function testGetAsString(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->createDeck();
        $result = $deck->getAsString($cards);
        $this->assertNotEmpty($result);
    }

}
