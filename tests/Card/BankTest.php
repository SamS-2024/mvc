<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the Bank class.
 */
class BankTest extends TestCase
{
    /**
     * Test that a Bank object can be created.
     */
    public function testBank(): void
    {
        $bank = new Bank();
        $this->assertInstanceOf(Bank::class, $bank);
    }

    /**
     * Test that a Bank can start a new round of play with the given hand.
     */
    public function testBankRound(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $bank->play($cardHand);

        $this->assertEquals($cardHand, $bank->getHand());
    }

    /**
     * Test that a Bank gets correct points in a round.
     */
    public function testRoundPoints(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();
        $card = new Card('🂵', 'hearts');
        $cardHand->addCard($card);

        $bank->play($cardHand);

        $points = $bank->getPoints();

        $this->assertEquals(5, $points);
    }

    /**
     * Test that a Bank can stop.
     */
    public function testBankStop(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();
        $card1 = new Card('🂮', 'spades');
        $card2 = new Card('🂾', 'hearts');
        $cardHand->addCard($card1);
        $cardHand->addCard($card2);

        $bank->play($cardHand);

        $bank->stop();

        $this->assertFalse($bank->isPlaying());
    }

    /**
     * Test if a Bank is bust (gets more than 21 points).
     */
    public function testBankBust(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();

        // 3 kort som ger mer än 21 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂾', 'hearts')); // 10
        $cardHand->addCard(new Card('🂥', 'spades')); // 5, Totalt: 25

        $bank->play($cardHand);

        $this->assertTrue($bank->isBust());
    }

    /**
     * Test if a Bank should stop (gets >= 17 points).
     */
    public function testBankShouldStop(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();

        // 2 kort som ger 18 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂨', 'spades')); // 8

        $bank->play($cardHand);

        $this->assertTrue($bank->shouldStop());
    }

    /**
     * Test Bank's status wheather it is bust or game still going based on
     * returned string text.
     */
    public function testBankStatusBust(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();

        // 3 kort som ger mer än 21 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂾', 'hearts')); // 10
        $cardHand->addCard(new Card('🂥', 'spades')); // 5, Totalt: 25

        $bank->play($cardHand);

        $this->assertStringContainsString("Bank is bust", $bank->checkStatus());
    }

    /**
     * Test Bank's status wheather it shoud stop, points >= 17 and less than 21.
     */
    public function testBankStatusShouldStop(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();

        // 2 kort som ger 18 poäng
        $cardHand->addCard(new Card('🂮', 'spades')); // 10
        $cardHand->addCard(new Card('🂨', 'spades')); // 8

        $bank->play($cardHand);

        $this->assertStringContainsString("Bank has stopped", $bank->checkStatus());
    }

    /**
     * Test Bank's status wheather it is bust or game still going based on
     * returned string text.
     */
    public function testBankStatusGameStillGoing(): void
    {
        $bank = new Bank();
        $cardHand = new CardHand();

        $cardHand->addCard(new Card('🂣', 'hearts')); // 3
        $cardHand->addCard(new Card('🂥', 'spades')); // 5


        $bank->play($cardHand);

        $this->assertStringContainsString("Game still going..", $bank->checkStatus());
    }
}
