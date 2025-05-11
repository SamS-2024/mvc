<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the CardGraphic class.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Test that a CardGraphic object can be created.
     */
    public function testCreateCardGraphic(): void
    {
        $card = new CardGraphic();
        $this->assertInstanceOf(CardGraphic::class, $card);
    }

    /**
     * Test that createDiamonds returns an array of 13 cards.
     */
    public function testCardsCountDiamonds(): void
    {
        $exp = 13;
        $card = new CardGraphic();
        $res = $card->createDiamonds();
        $this->assertCount($exp, $res);
    }

    /**
     * Test that createHearts returns an array of 13 cards.
     */
    public function testCardsCountHearts(): void
    {
        $exp = 13;
        $card = new CardGraphic();
        $res = $card->createHearts();
        $this->assertCount($exp, $res);
    }

    /**
     * Test that createClubs returns an array of 13 cards.
     */
    public function testCardsCountClubs(): void
    {
        $exp = 13;
        $card = new CardGraphic();
        $res = $card->createClubs();
        $this->assertCount($exp, $res);
    }

    /**
     * Test that createSpades returns an array of 13 cards.
     */
    public function testCardsCountSpades(): void
    {
        $exp = 13;
        $card = new CardGraphic();
        $res = $card->createSpades();
        $this->assertCount($exp, $res);
    }

    /**
     * Test that formatCards returns a string with red span for red suits.
     */
    public function testFormatCardsDiamonds(): void
    {
        $cardGraphic = new CardGraphic();
        $cards = $cardGraphic->createDiamonds(); // Röda kort
        $result = $cardGraphic->formatCards($cards);

        // $this->assertIsString($result);
        $this->assertStringContainsString('<span class="red">', $result);
    }

    /**
     * Test that formatCard returns the symbol for a black card.
     */
    public function testFormatCardReturnsSymbol(): void
    {
        $card = new CardGraphic();
        $inputCard = new Card('🂡', 'spades');

        $result = $card->formatCard($inputCard);
        $exp = '🂡';

        $this->assertEquals($exp, $result);
    }

}
