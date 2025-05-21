<?php

namespace App\Dice;

use App\Dice\Dice;

/**
 * Class DiceHand
 *
 * Represents a collection of dice that can be rolled together.
 */
class DiceHand
{
    /** @var \App\Dice\Dice[] An array of Dice objects in the hand. */
    private array $hand = [];

    /**
     * Add a die to the hand.
     *
     * @param Dice $die The die to be added.
     */
    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    /**
     * Roll all dice in the hand.
     */
    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    /**
     * Get the number of dice in the hand.
     *
     * @return int The number of dice.
     */
    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * Get the numeric values of all rolled dice.
     *
     * @return int[] An array of integer values from each die.
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $value = $die->getValue();
            if ($value !== null) {
                $values[] = $value;
            }
        }
        return $values;
    }

    /**
     * Get the string representation of each die in the hand.
     *
     * @return string[] An array of string representations (e.g., Unicode symbols).
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
