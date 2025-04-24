<?php

namespace App\Card;

/**
 * Represents a playing card with graphical symbols.
 * Extends the Card class by adding suit symbols and value constants.
 */
class CardGraphic extends Card
{
    /** @var string[] */
    protected array $spades;

    /** @var string[] */
    protected array $hearts;

    /** @var string[] */
    protected array $diamonds;

    /** @var string[] */
    protected array $clubs;

    public const MIN_VALUE = 2;
    public const MAX_VALUE = 14;

    /**
     * Initializes the arrays used to store card symbols for each suit.
     */
    public function __construct()
    {
        $this->spades = [];
        $this->hearts = [];
        $this->diamonds = [];
        $this->clubs = [];
    }

    /**
     * Creates card objects for spades using Unicode symbols.
     *
     * @return Card[] Array of spade card objects.
     */
    public function createSpades(): array
    {
        $spadesCards = [];

        $this->spades = [
            '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮', '🂡'
        ];

        $spadesCards = $this->createCardObjects($this->spades, 'spades');

        return $spadesCards;
    }

    /**
     * Creates card objects for hearts using Unicode symbols.
     *
     * @return Card[] Array of hearts card objects.
     */
    public function createHearts(): array
    {
        $heartsCards = [];

        $this->hearts = [
            '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'
        ];

        $heartsCards = $this->createCardObjects($this->hearts, 'hearts');

        return $heartsCards;
    }

    /**
     * Creates card objects for diamonds using Unicode symbols.
     *
     * @return Card[] Array of diamonds card objects.
     */
    public function createDiamonds(): array
    {
        $diamondsCards = [];

        $this->diamonds = [
            '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'
        ];

        $diamondsCards = $this->createCardObjects($this->diamonds, 'diamonds');


        return $diamondsCards;
    }

    /**
     * Creates card objects for clubs using Unicode symbols.
     *
     * @return Card[] Array of clubs card objects.
     */
    public function createClubs(): array
    {
        $clubsCards = [];

        $this->clubs = [
            '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑'
        ];

        $clubsCards = $this->createCardObjects($this->clubs, 'clubs');

        return $clubsCards;
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
            // Skickar både svit och symbol
            $cards[] = new Card($representation[$i - 2], $suit);
        }

        return $cards;
    }

    /**
     * Returns a string representation of multiple cards with HTML styling for red cards.
     *
     * @param Card[] $cardsArray An array of Card objects.
     * @return string A string of card symbols with red coloring where applicable.
     */
    public function getAsString(array $cardsArray): string
    {
        $strings = [];

        foreach ($cardsArray as $card) {
            // Reuse formatCard for each card
            $strings[] = $this->formatCard($card);
        }

        return implode(" ", $strings);
    }


    /**
     * Formats a card as an HTML string, with handling for red cards.
     *
     * @param Card $card The card to be formatted.
     *
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
