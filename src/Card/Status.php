<?php

namespace App\Card;

/**
 * Represents the game status and the winner/ loser of it.
 */
class Status
{
    protected Player $player;
    protected Bank $bank;
    public const MAX_VALUE = 21;

    public function __construct(Player $player, Bank $bank)
    {
        $this->player = $player;
        $this->bank = $bank;
    }

    public function winner(): string
    {
        $playerPoints = $this->player->getPoints();
        $bankPoints = $this->bank->getPoints();

        // Om spelaren får över 21, banken vinner
        if ($playerPoints > self::MAX_VALUE) {
            return "The winner is {$this->getBankName()}";
        }

        // Om spelaren får exakt 21 och banken inte gör det, spelaren vinner
        if ($playerPoints === self::MAX_VALUE && $bankPoints !== self::MAX_VALUE) {
            return "The winner is {$this->getPlayerName()}";
        }

        // Om banken får exakt 21, vinner banken oavsett.
        if ($bankPoints === self::MAX_VALUE) {
            return "The winner is {$this->getBankName()}";
        }

        // Om banken får mer poäng än spelaren eller banken har bättre skillnad från 21
        $playerDifference = self::MAX_VALUE - $playerPoints;
        $bankDifference = self::MAX_VALUE - $bankPoints;

        if ($bankPoints >= $playerPoints || $bankDifference < $playerDifference) {
            return "The winner is {$this->getBankName()}";
        }

        // Om banken får mer än 21, spelaren vinner eller spelaren har bättre skillnad från 21
        if ($bankPoints > self::MAX_VALUE || $playerDifference < $bankDifference) {
            return "The winner is {$this->getPlayerName()}";
        }

    return "Game is over";
}


    public function getPlayerName(): string
    {
        return "You";
    }

    public function getBankName(): string
    {
        return "Bank";
    }
}
