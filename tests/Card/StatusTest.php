<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Test cases for the Status class.
 */
class StatusTest extends TestCase
{
    /**
     * Test that a Status object can be created.
     */
    public function testStatus(): void
    {
        $player = new Player();
        $bank = new Bank();
        $status = new Status($player, $bank);
        $this->assertInstanceOf(Status::class, $status);
    }

    /**
     * Tests that the player wins when having more points than the bank.
     */
    public function testPlayerWinsWithMorePoints(): void
    {
        $playerHand = new CardHand();
        $playerHand->addCard(new Card('🂸', 'hearts')); // 8
        $playerHand->addCard(new Card('🂻', 'hearts')); // 11

        $bankHand = new CardHand();
        $bankHand->addCard(new Card('🂳', 'hearts')); // 3
        $bankHand->addCard(new Card('🂴', 'hearts')); // 4

        $player = new Player();
        $player->play($playerHand);

        $bank = new Bank();
        $bank->play($bankHand);

        $status = new Status($player, $bank);
        $this->assertEquals("The winner is You", $status->winner());
    }

    /**
     * Tests that the bank wins when having more points than the player.
     */
    public function testBankWinsWithMorePoints(): void
    {
        $playerHand = new CardHand();
        $playerHand->addCard(new Card('🂳', 'hearts')); // 8
        $playerHand->addCard(new Card('🂴', 'hearts')); // 11

        $bankHand = new CardHand();
        $bankHand->addCard(new Card('🂸', 'hearts')); // 3
        $bankHand->addCard(new Card('🂻', 'hearts')); // 4

        $player = new Player();
        $player->play($playerHand);

        $bank = new Bank();
        $bank->play($bankHand);

        $status = new Status($player, $bank);
        $this->assertEquals("The winner is Bank", $status->winner());
    }

    /**
     * Tests that the player wins when the bank goes bust (over 21).
     */
    public function testPlayerWinsWhenBankIsBust(): void
    {
        $playerHand = new CardHand();
        $playerHand->addCard(new Card('🂸', 'hearts')); // 8
        $playerHand->addCard(new Card('🂻', 'hearts')); // 11

        $bankHand = new CardHand();
        $bankHand->addCard(new Card('🃋', 'diamonds')); // 11
        $bankHand->addCard(new Card('🂻', 'hearts')); // 11

        $player = new Player();
        $player->play($playerHand);

        $bank = new Bank();
        $bank->play($bankHand);

        $status = new Status($player, $bank);
        $this->assertEquals("The winner is You", $status->winner());
    }

    /**
     * Tests that the player wins by reaching exactly 21 points.
     */
    public function testPlayerWinsByPoints21(): void
    {
        $playerHand = new CardHand();
        $playerHand->addCard(new Card('🂺', 'hearts')); // 10
        $playerHand->addCard(new Card('🂻', 'hearts')); // 11

        $bankHand = new CardHand();
        $bankHand->addCard(new Card('🃓', 'clubs')); // 3
        $bankHand->addCard(new Card('🂻', 'hearts')); // 11

        $player = new Player();
        $player->play($playerHand);

        $bank = new Bank();
        $bank->play($bankHand);

        $status = new Status($player, $bank);
        $this->assertEquals("The winner is You", $status->winner());
    }
}
