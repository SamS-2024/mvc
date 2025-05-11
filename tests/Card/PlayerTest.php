<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the Player class.
 */
class PlayerTest extends TestCase
{
    /**
     * Test that a Player object can be created.
     */
    public function testPlayer(): void
    {
        $player = new Player();
        $this->assertInstanceOf(Player::class, $player);
    }

    /**
     * Test that a Player can start a new round of play with the given hand.
     */
    public function testPlayerRound(): void
    {
        $player = new Player();
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $player->play($cardHand);

        $this->assertEquals($cardHand, $player->getHand());
    }

    /**
     * Test that a Player gets correct points in a round.
     */
    public function testRoundPoints(): void
    {
        $player = new Player();
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $player->play($cardHand);

        $points = $player->getPoints();

        $this->assertEquals(5, $points);
    }

    /**
     * Test that a Player can stop.
     */
    public function testPlayerStop(): void
    {
        $player = new Player();
        $cardHand = new CardHand();
        $card1 = new Card('🂮', 'spades');
        $card2 = new Card('🂾', 'hearts');
        $cardHand->addCard($card1);
        $cardHand->addCard($card2);

        $player->play($cardHand);

        $player->stop();

        $this->assertFalse($player->isPlaying());
    }

    /**
     * Test if a Player is bust (gets more than 21 points).
     */
    public function testPlayerBust(): void
    {
        $player = new Player();
        $cardHand = new CardHand();

        // 3 kort som ger mer än 21 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂾', 'hearts')); // 10
        $cardHand->addCard(new Card('🂥', 'spades')); // 5, Totalt: 25

        $player->play($cardHand);

        $this->assertTrue($player->isBust());
    }

    /**
     * Test Player's status wheather it is bust or game still going based on
     * returned string text.
     */
    public function testPlayerStatusBust(): void
    {
        $player = new Player();
        $cardHand = new CardHand();

        // 3 kort som ger mer än 21 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂾', 'hearts')); // 10
        $cardHand->addCard(new Card('🂥', 'spades')); // 5, Totalt: 25

        $player->play($cardHand);

        $this->assertStringContainsString("Player is bust", $player->checkStatus());
    }

    /**
     * Test Player's status wheather it is bust or game still going based on
     * returned string text.
     */
    public function testPlayerStatusGameStillGoing(): void
    {
        $player = new Player();
        $cardHand = new CardHand();

        $cardHand->addCard(new Card('🂣', 'hearts')); // 3
        $cardHand->addCard(new Card('🂥', 'spades')); // 5


        $player->play($cardHand);

        $this->assertStringContainsString("Game still going..", $player->checkStatus());
    }
}
