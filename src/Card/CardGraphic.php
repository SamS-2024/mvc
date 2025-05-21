<?php

namespace App\Card;

/**
 * Represents a playing card with graphical symbols.
 * Extends the Card class by adding suit symbols and value constants.
 */
class CardGraphic extends Card
{
    public const MIN_VALUE = 2;
    public const MAX_VALUE = 14;

    /** @var array<string, string[]> */
    private const SUITS = [
        'spades' => ['🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮', '🂡'],
        'hearts' => ['🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'],
        'diamonds' => ['🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'],
        'clubs' => ['🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑'],
    ];

    /**
     * Initializes the object.
     */
    public function __construct()
    {
        // No need to initialize anything here now
    }

    /**
     * Creates card objects for spades using Unicode symbols.
     *
     * @return Card[] Array of spade card objects.
     */
    public function createSpades(): array
    {
        return $this->createCardObjects(self::SUITS['spades'], 'spades');
    }

    /**
     * Creates card objects for hearts using Unicode symbols.
     *
     * @return Card[] Array of hearts card objects.
     */
    public function createHearts(): array
    {
        return $this->createCardObjects(self::SUITS['hearts'], 'hearts');
    }

    /**
     * Creates card objects for diamonds using Unicode symbols.
     *
     * @return Card[] Array of diamonds card objects.
     */
    public function createDiamonds(): array
    {
        return $this->createCardObjects(self::SUITS['diamonds'], 'diamonds');
    }

    /**
     * Creates card objects for clubs using Unicode symbols.
     *
     * @return Card[] Array of clubs card objects.
     */
    public function createClubs(): array
    {
        return $this->createCardObjects(self::SUITS['clubs'], 'clubs');
    }

    /**
     * Creates card objects from a symbol array and suit name.
     *
     * @param array<string> $representation Array of card symbols.
     * @param string $suit The suit of the cards.
     * @return Card[] Array of Card objects.
     */
    public function createCardObjects(array $representation, string $suit): array
    {
        $cards = [];

        for ($i = self::MIN_VALUE; $i <= self::MAX_VALUE; $i++) {
            $cards[] = new Card($representation[$i - self::MIN_VALUE], $suit);
        }

        return $cards;
    }

    /**
     * Returns a string representation of multiple cards with HTML styling for red cards.
     *
     * @param Card[] $cardsArray An array of Card objects.
     * @return string A string of card symbols with red coloring where applicable.
     */
    public function formatCards(array $cardsArray): string
    {
        $strings = [];

        foreach ($cardsArray as $card) {
            $strings[] = $this->formatCard($card);
        }

        return implode(" ", $strings);
    }

    /**
     * Formats a card as an HTML string, with handling for red cards.
     *
     * @param Card $card The card to be formatted.
     * @return string The formatted card string.
     */
    public function formatCard(Card $card): string
    {
        $symbol = $card->getRank();

        if ($card->getColor() === 'red') {
            return '<span class="red">' . $symbol . '</span>';
        }

        return $symbol;
    }
}
