<?php

namespace App\Card;

class CardGraphic extends Card
{
    protected $spades;
    protected $hearts;
    protected $diamonds;
    protected $clubs;
    const MIN_VALUE = 2;
    const MAX_VALUE = 14;

    public function __construct()
    {
        $this->spades = [];
        $this->hearts = [];
        $this->diamonds = [];
        $this->clubs = [];
    }

    public function createSpades(): array
    {
        $spadesCards = [];

        $this->spades = [
            '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮', '🂡'
        ];

        $spadesCards = $this->createCardObjects($this->spades, 'spades');

        return $spadesCards;
}

    public function createHearts(): array
    {
        $heartsCards = [];

        $this->hearts = [
            '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'
        ];

        $heartsCards = $this->createCardObjects($this->hearts, 'hearts');

        return $heartsCards;
    }

    public function createDiamonds(): array
    {
        $diamondsCards = [];

        $this->diamonds = [
            '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'
        ];

        $diamondsCards = $this->createCardObjects($this->diamonds, 'diamonds');

        return $diamondsCards;
    }

    public function createClubs(): array
    {
        $clubsCards = [];

        $this->clubs = [
            '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑'
        ];

        $clubsCards = $this->createCardObjects($this->clubs, 'clubs');

        return $clubsCards;
    }

    public function createCardObjects(array $representation, string $suit): array
    {
    $cards = [];

    for($i = self::MIN_VALUE; $i <= self::MAX_VALUE; $i++) {
        $cards[] = new Card($representation[$i - 2], $suit);  // Skickar både svit och symbol
    }

    return $cards;

    }

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
