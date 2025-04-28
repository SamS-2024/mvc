<?php

namespace App\Card;

/**
 * Represents the bank in the game.
 */

class Bank
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
     * The value at which the bank should stop (17 or higher).
     */
    public const STOP_VALUE = 17;

    /**
     * Starts a new round of play with the given hand.
     *
     * @param CardHand $hand The bank's card hand.
     */
    public function play(CardHand $hand): void
    {
        $this->hand = $hand;
        $this->isPlaying = true;
    }

    /**
     * Gets the bank's current hand of cards.
     *
     * @return CardHand The bank's hand.
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * Stops the bank's turn, marking it as no longer playing.
     */
    public function stop(): void
    {
        $this->isPlaying = false;
    }

    /**
     * Gets the total points of the bank's hand.
     *
     * @return int The total points of the bank's hand.
     */
    public function getPoints(): int
    {
        return $this->hand->getPoints();
    }

    /**
     * Determines if the bank should stop playing based on its points.
     *
     * @return bool True if the bank should stop, otherwise false.
     */
    public function shouldStop(): bool
    {
        return $this->getPoints() >= self::STOP_VALUE;
    }


    /**
     * Checks if the bank has gone bust (over 21 points).
     *
     * @return bool True if the bank has gone bust, otherwise false.
     */
    public function isBust(): bool
    {
        return $this->getPoints() > self::MAX_VALUE;
    }

    /**
     * Checks if the bank is currently playing.
     *
     * @return bool True if the bank is playing, otherwise false.
     */
    public function isPlaying(): bool
    {
        return $this->isPlaying;
    }

    /**
     * Checks the current status of the bank (whether it is bust, has stopped, or is still playing).
     *
     * @return string A message indicating the bank's current status.
     */
    public function checkStatus(): string
    {
        if ($this->isBust()) {
            return "Bank is bust";
        } elseif ($this->shouldStop()) {
            return "Bank has stopped";
        }
        return "Game still going..";
    }
}
