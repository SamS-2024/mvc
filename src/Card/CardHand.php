<?php

namespace App\Card;

/**
 * Represents a playing hand with cards.
 */
class CardHand
{
    /**
     * @var Card[] List of cards in the hand.
     */
    protected array $cardsArray = [];

    /**
     * Adds a card to the hand.
     *
     * @param Card $card The card to be added to the hand.
     */
    public function addCard(Card $card): void
    {
        // Lägger till ett kort i handen
        $this->cardsArray[] = $card;
    }

    /**
     * Retrieves all cards in the hand.
     *
     * @return \App\Card\Card[] An array of Card objects.
     */
    public function getCards(): array
    {
        // Hämtar alla kort i handen
        return $this->cardsArray;
    }

    /**
     * Calculates and returns the total points for the hand based on the cards.
     *
     * @return int The total points of the hand.
     */
    public function getPoints(): int
    {
        $points = 0;
        foreach ($this->cardsArray as $card) {
            // Anropar getCardValue() från Card-klassen för att beräkna poäng för varje kort.
            $points += $card->getCardValue();
        }

        return $points;
    }

    /**
     * Retrieves all cards in the hand as a string formatted for display.
     *
     * @return string A string representing all the cards in the hand, formatted.
     */
    public function getCardsAsString(): string
    {   // Skapar ett CardGraphic-objekt
        $cardGraphic = new CardGraphic();
        // Skickar alla kort till formatCards-metoden
        return $cardGraphic->formatCards($this->cardsArray);
    }
}
