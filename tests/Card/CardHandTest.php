<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the CardHand class.
 */
class CardHandTest extends TestCase
{
    /**
     * Test that a CardHand object can be created.
     */
    public function testCardHandCards(): void
    {
        $card = new CardHand();
        $this->assertInstanceOf(CardHand::class, $card);
    }

    /**
     * Test adding a card to the card hand.
     */
    public function testAddCardToCardHand(): void
    {
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $cards = $cardHand->getCards();
        $this->assertCount(1, $cards);
    }

    /**
     * Test that points are correctly calculated for a card hand.
     */
    public function testGetCardHandPoints(): void
    {
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $points = $cardHand->getPoints();
        $this->assertEquals(5, $points);
    }

    /**
     * Test that the card hand returns a string representation of its cards.
     */
    public function testGetCardAsString(): void
    {
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $this->assertNotEmpty($cardHand->getCardsAsString());
    }



}
