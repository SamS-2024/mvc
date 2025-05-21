<?php

namespace App\Dice;

/**
 * Represents a six-sided die with roll and display functionality.
 */
class Dice
{
    /** @var int|null The current value of the die, or null if not rolled yet */
    protected ?int $value;

    public function __construct()
    {
        $this->value = null;
    }

    /**
     * Roll the die and return the result.
     */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
     * Get the current value of the die.
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Get the string representation of the die.
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
