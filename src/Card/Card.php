<?php

namespace App\Card;

/**
 * Represents a playing card with rank and suit.
 */
class Card
{
    private $rank;
    private $suit;

    /**
     * Create a card with given rank and suit.
     */
    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    /**
     * Get the suit of the card.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get the rank of the card.
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * Get the color based on the suit.
     */
    public function getColor(): string
    {
        if ($this->suit === 'hearts' || $this->suit === 'diamonds') {
            return 'red';
        }
        return 'black';
    }

    /**
     * Get the card as a JSON-compatible array.
     */
    public function getAsJson(): array
    {

        return  [
            'rank' => $this->getRank(),
            'suit' => $this->getSuit()
        ];
    }
}
