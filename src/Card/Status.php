<?php

namespace App\Card;

/**
 * Represents the game status and the winner/ loser of it.
 */
class Status
{
    /**
     * @var Player
     */
    protected Player $player;

    /**
     * @var Bank
     */
    protected Bank $bank;

    /**
     * The maximum allowed value in the game (21).
     */
    public const MAX_VALUE = 21;

    /**
     * Status constructor.
     *
     * @param Player $player The player participating in the game.
     * @param Bank $bank The bank (dealer) in the game.
     */
    public function __construct(Player $player, Bank $bank)
    {
        $this->player = $player;
        $this->bank = $bank;
    }

    /**
     * Determines the winner of the game.
     * This method evaluates the points of both the
     * player and the bank and decides who the winner is based on their points.
     * @return string A message indicating the winner of the game.
     */
    public function winner(): string
    {
        $playerPoints = $this->player->getPoints();
        $bankPoints = $this->bank->getPoints();

        // Om banken får över 21, spelaren vinner
        if ($bankPoints > self::MAX_VALUE) {
            return "The winner is {$this->getPlayerName()}";
        }

        // Om spelaren får exakt 21 och banken inte gör det, spelaren vinner
        if ($playerPoints === self::MAX_VALUE && $bankPoints !== self::MAX_VALUE) {
            return "The winner is {$this->getPlayerName()}";
        }

        // Om spelaren får mer poäng än banken men har mindre än 21 (inte bust), vinner spelaren.
        if ($playerPoints > $bankPoints && $playerPoints < self::MAX_VALUE) {
            return "The winner is {$this->getPlayerName()}";
        }

        // Annars vinner banken.
        return "The winner is {$this->getBankName()}";
    }


    /**
     * Gets the name of the player.
     *
     * @return string The name of the player.
     */
    public function getPlayerName(): string
    {
        return "You";
    }

    /**
     * Gets the name of the bank (dealer).
     *
     * @return string The name of the bank.
     */
    public function getBankName(): string
    {
        return "Bank";
    }
}
