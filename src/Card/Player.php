<?php

namespace App\Card;

/**
 * Represents a player.
 */
class Player
{
    protected CardHand $hand;
    protected bool $isPlaying = true;
    public const MAX_VALUE = 21;


    public function play(CardHand $hand): void {
      $this->hand = $hand;
      $this->isPlaying = true;
    }

    public function getHand(): CardHand {
        return $this->hand;
    }

    public function stop(): void {
        $this->isPlaying = false;
    }

    public function getPoints(): int
    {
        return $this->hand->getPoints();
    }

    public function isBust(): bool
    {
        return $this->getPoints() > self::MAX_VALUE;
    }

    public function isPlaying(): bool
    {
        return $this->isPlaying;
    }

    public function checkStatus(): string
    {

        if ($this->isBust()) {
            return "Player is bust";
        }
        return "Game still going..";
    }

}
