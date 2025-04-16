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

        $spadesCards = $this->createCardObjects($this->spades);

        return $spadesCards;
}

    public function createHearts(): array
    {
        $heartsCards = [];

        $this->hearts = [
            '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', '🂱'
        ];


        $heartsCards = $this->createCardObjects($this->hearts);

        return $heartsCards;
    }

    public function createDiamonds(): array
    {
        $diamondsCards = [];

        $this->diamonds = [
            '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', '🃁'
        ];

        $diamondsCards = $this->createCardObjects($this->diamonds);

        return $diamondsCards;
    }

    public function createClubs(): array
    {
        $clubsCards = [];

        $this->clubs = [
            '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', '🃑'
        ];

        $clubsCards = $this->createCardObjects($this->clubs);

        return $clubsCards;
    }

    public function createCardObjects(array $represenation): array
    {
        $cards = [];

        for($i = self::MIN_VALUE; $i <= self::MAX_VALUE; $i++) {

            $cards[] = new Card($represenation[$i - 2], $i);
        }
        return $cards;
    }

    public function getAsString(array $cardsArray): string
    {
        $strings = [];

        foreach($cardsArray as $card) {
            $strings[] = $card->getSuit();
        }

        return implode(" ", $strings);
    }
}
