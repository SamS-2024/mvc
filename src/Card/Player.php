<?php

namespace App\Card;

/**
 * Represents a player.
 */
class Player
{
    /**
     * @var CardHand
     */
    protected CardHand $hand;

    /**
     * @var bool
     */
    protected bool $isPlaying = true;

    /**
     * The maximum allowed value in the game (21).
     */
    public const MAX_VALUE = 21;


    /**
     * Starts a new round of play with the given hand.
     *
     * @param CardHand $hand The player's card hand.
     */
    public function play(CardHand $hand): void
    {
        $this->hand = $hand;
        $this->isPlaying = true;
    }

    /**
     * Gets the player's current hand of cards.
     *
     * @return CardHand The player's hand.
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * Stops the player's turn, marking them as no longer playing.
     */
    public function stop(): void
    {
        $this->isPlaying = false;
    }

    /**
     * Gets the total points of the player's hand.
     *
     * @return int The total points of the player's hand.
     */
    public function getPoints(): int
    {
        return $this->hand->getPoints();
    }

    /**
     * Checks if the player has gone bust (over 21 points).
     *
     * @return bool True if the player has gone bust, otherwise false.
     */
    public function isBust(): bool
    {
        return $this->getPoints() > self::MAX_VALUE;
    }

    /**
     * Checks if the player is currently playing.
     *
     * @return bool True if the player is playing, otherwise false.
     */
    public function isPlaying(): bool
    {
        return $this->isPlaying;
    }

    /**
     * Checks the current status of the player (whether they are bust or still playing).
     *
     * @return string A message indicating the player's current status.
     */
    public function checkStatus(): string
    {

        if ($this->isBust()) {
            return "Player is bust";
        }

        return "Game still going..";
    }

}
