<?php

namespace App\Card;

class DeckOfCards
{
    protected $cardsArray;
    protected $cardGraphic;

    public function __construct()
    {
        $this->cardsArray = [];
        // Komposition av CardGraphic
        $this->cardGraphic = new CardGraphic();
    }

    public function createDeck(): array
    {
        // Skapar en deck av kort med hjälp av CardGraphic
        $spades = $this->cardGraphic->createSpades();
        $hearts = $this->cardGraphic->createHearts();
        $diamonds = $this->cardGraphic->createDiamonds();
        $clubs = $this->cardGraphic->createClubs();

        $this->cardsArray = array_merge($spades, $hearts, $diamonds, $clubs);

        return $this->cardsArray;
    }

    public function shuffleCards(): array
    {
        shuffle($this->cardsArray);

        return $this->cardsArray;
    }


    public function getAsString(array $arrayOfCards): string
    {

        return $this->cardGraphic->getAsString($arrayOfCards);
    }


    public function getAsJson(): array
    {
        $deckData = [];
        foreach ($this->cardsArray as $card) {
            $deckData[] = [
                'rank' => $card->getRank(),
                'color' => $card->getColor()
            ];
        }
        return $deckData;
    }

}
