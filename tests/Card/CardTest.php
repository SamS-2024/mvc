<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */

    public function testCreateCard()
    {
        $card = new Card(5, "hearts");
        $this->assertInstanceOf(Card::class, $card);
    }

    public function testCardJson()
    {
        $card = new Card(5, "hearts");
        $res = $card->getAsJson();
        $this->assertNotEmpty($res);
    }

    public function testCardSuit()
    {
        $card = new Card(5, "hearts");
        $res = $card->getSuit();
        $exp = "hearts";
        $this->assertEquals($exp, $res);
    }

    public function testCardRank()
    {
        $card = new Card(5, "hearts");
        $res = $card->getRank();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    public function testCardColorRed()
    {
        $card = new Card(5, "hearts");
        $res = $card->getColor();
        $exp = "red";
        $this->assertEquals($exp, $res);
    }

    public function testCardColorBlack()
    {
        $card = new Card(5, "clubs");
        $res = $card->getColor();
        $exp = "black";
        $this->assertEquals($exp, $res);
    }

    public function testCardValueReturnsCorrectValue()
    {
        $card = new Card('🂵', 'hearts');
        $this->assertEquals(5, $card->getCardValue());
    }

    public function testCardValueReturnsZero()
    {
        $card = new Card('', 'hearts');
        $this->assertEquals(0, $card->getCardValue());
    }
}
