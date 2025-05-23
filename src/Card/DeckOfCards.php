<?php

namespace App\Card;

/**
 * Represents a full deck of playing cards, including graphical symbols.
 * Manages creation, shuffling, and retrieval of cards.
 */
class DeckOfCards
{
    /** @var Card[] */
    protected array $cardsArray;
    protected CardGraphic $cardGraphic;

    /**
    * Initializes the deck with an empty cards array and a CardGraphic instance.
    */
    public function __construct()
    {
        $this->cardsArray = [];
        // Komposition av CardGraphic
        $this->cardGraphic = new CardGraphic();
    }

    /**
     * Creates a deck of cards by generating cards for each suit
     * (spades, hearts, diamonds, clubs).
     * Merges the cards into a single array and returns it.
     * @return Card[] Array of Card objects.
     */
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

    /**
     * Shuffles the deck of cards and returns the shuffled array.
     * @return Card[]
     */
    public function shuffleCards(): array
    {
        shuffle($this->cardsArray);

        return $this->cardsArray;
    }

    /**
     * Converts a cards object into a string representation.
     *
     * @param Card $card A Card objects.
     * @return string A string representation of the card.
     */
    public function getCardAsString(Card $card): string
    {

        return $this->cardGraphic->formatCard($card);
    }

    /**
     * Converts an array of cards into a string representation.
     *
     * @param Card[] $arrayOfCards An array of Card objects.
     * @return string A string representation of the cards.
     */
    public function getAsString(array $arrayOfCards): string
    {

        return $this->cardGraphic->formatCards($arrayOfCards);
    }

    /**
     * Converts the deck of cards into a JSON-compatible array.
     *
     * @return array<int, array<string, string>> An array representation of the deck.
     */
    public function getAsJson(): array
    {
        $deckData = [];
        foreach ($this->cardsArray as $card) {
            $deckData[] = $card->getAsJson(); // Använder getAsJson på varje kort
        }
        return $deckData;
    }

    /**
     * Draws and returns a single card from the deck.
     *
     * @return Card The card that was drawn from the deck.
     */

    public function drawCard(): ?Card
    {
        $removedCard = array_pop($this->cardsArray);
        return $removedCard;
    }

    /**
     * Returns the number of remaining cards in the deck.
     *
     * @return int The count of remaining cards in the deck.
     */
    public function getRemainingCount(): int
    {
        return count($this->cardsArray);
    }

    /**
     * Draws a specified number of cards from the deck.
     *
     * @param int $num The number of cards to draw.
     * @return Card[] An array of Card objects drawn from the deck.
     */
    public function drawCards(int $num): array
    {

        $removedCards = [];

        for ($i = 0; $i < $num && !empty($this->cardsArray); $i++) {
            $removedCards[] = array_pop($this->cardsArray);
        }

        return $removedCards;
    }
}
