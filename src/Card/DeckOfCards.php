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
     * Converts an array of cards into a string representation.
     *
     * @param Card[] $arrayOfCards An array of Card objects.
     * @return string A string representation of the cards.
     */
    public function getAsString(array $arrayOfCards): string
    {

        return $this->cardGraphic->getAsString($arrayOfCards);
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

    /////
    //     public function drawCards(int $num, array $shuffledCards): array
    // {
    //     $removedCards = [];
    //     $count = 0;
    //     $cardString = '';

    //     while ($count < $num && !empty($shuffledCards)) {
    //         $removedCards[] = array_pop($shuffledCards);
    //         $count++;
    //     }

    //     // Bygg cardString här
    //     foreach ($removedCards as $card) {
    //         $cardString .= $card->getRank() . ' ';
    //     }

    //     return [
    //         'cardString' => $cardString,
    //         'remainingCards' => $shuffledCards, // Kvarvarande kort (inte count)
    //         'count' => $count // Antal dragna kort
    //     ];
    //}


}
