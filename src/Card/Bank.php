<?php

namespace App\Card;


/**
 * Represents the bank.
 */
class Bank
{
    protected CardHand $hand;
    protected bool $isPlaying = true;
    public const MAX_VALUE = 21;
    public const STOP_VALUE = 17;

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

    public function shouldStop(): bool
    {
        return $this->getPoints() >= self::STOP_VALUE;
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
            return "Bank is bust";
        } else if ($this->shouldStop()) {
            return "Bank has stopped";
        }
        return "Game still going..";
    }
}
