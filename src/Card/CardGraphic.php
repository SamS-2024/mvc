<?php

namespace App\Card;

/**
 * Represents a playing card with graphical symbols.
 * Extends the Card class by adding suit symbols and value constants.
 */
class CardGraphic extends Card
{
    protected $spades;
    protected $hearts;
    protected $diamonds;
    protected $clubs;
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
     * @return array Array of spade card objects.
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
     * @return array Array of hearts card objects.
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
     * @return array Array of diamonds card objects.
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
     * @return array Array of clubs card objects.
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
     * @param array $representation Array of card symbols.
     * @param string $suit The suit of the cards.
     * @return array Array of Card objects.
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
     * Returns a string representation of cards with HTML styling for red cards.
     *
     * @param array $cardsArray Array of Card objects.
     * @return string String of card symbols with red coloring where applicable.
     */
    public function getAsString(array $cardsArray): string
    {
        $strings = [];

        foreach ($cardsArray as $card) {
            $symbol = $card->getRank();

            if ($card->getColor() === 'red') {
                $strings[] = '<span class="red">' . $symbol . '</span>';
            } else {
                $strings[] = $symbol;
            }
        }

        return implode(" ", $strings);
    }
}
