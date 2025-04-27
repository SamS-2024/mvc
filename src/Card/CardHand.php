<?php

namespace App\Card;

/**
 * Represents a playing hand with cards.
 */
class CardHand
{
    protected array $cardsArray = [];

    public function addCard(Card $card): void {
        // Lägger till ett kort i handen
        $this->cardsArray[] = $card;
    }

    public function getCards(): array {
        // Hämtar alla kort i handen
        return $this->cardsArray;
    }


    public function getPoints(): int
    {
        $points = 0;
        foreach ($this->cardsArray as $card) {
            // Anropar getCardValue() från Card-klassen för att beräkna poäng för varje kort.
            $points += $card->getCardValue();
        }

        return $points;
    }

    public function getCardsAsString(): string
    {   // Skapar ett CardGraphic-objekt
        $cardGraphic = new CardGraphic();
        // Skickar alla kort till formatCards-metoden
        return $cardGraphic->formatCards($this->cardsArray);
    }
}
