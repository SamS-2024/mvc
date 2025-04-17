<?php

namespace App\Card;

class Card
{
    private $rank;
    private $suit;

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getColor(): string
    {
        if ($this->suit === 'hearts' || $this->suit === 'diamonds') {
            return 'red';
        }
        return 'black';
    }
}
