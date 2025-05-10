<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Test that a Card object can be created.
     */
    public function testCreateCard()
    {
        $card = new Card(5, "hearts");
        $this->assertInstanceOf(Card::class, $card);
    }

    /**
     * Test that getAsJson returns a non-empty JSON string.
     */
    public function testCardJson()
    {
        $card = new Card(5, "hearts");
        $res = $card->getAsJson();
        $this->assertNotEmpty($res);
    }

    /**
     * Test that getSuit returns the correct suit.
     */
    public function testCardSuit()
    {
        $card = new Card(5, "hearts");
        $res = $card->getSuit();
        $exp = "hearts";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that getRank returns the correct rank.
     */
    public function testCardRank()
    {
        $card = new Card(5, "hearts");
        $res = $card->getRank();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that getColor returns 'red' for hearts.
     */
    public function testCardColorRed()
    {
        $card = new Card(5, "hearts");
        $res = $card->getColor();
        $exp = "red";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that getColor returns 'black' for clubs.
     */
    public function testCardColorBlack()
    {
        $card = new Card(5, "clubs");
        $res = $card->getColor();
        $exp = "black";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that getCardValue returns the correct value for a known symbol.
     */
    public function testCardValueReturnsCorrectValue()
    {
        $card = new Card('🂵', 'hearts');
        $this->assertEquals(5, $card->getCardValue());
    }

    /**
     * Test that getCardValue returns 0 for an unknown symbol.
     */
    public function testCardValueReturnsZero()
    {
        $card = new Card('', 'hearts');
        $this->assertEquals(0, $card->getCardValue());
    }
}
