<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\Player;
use App\Card\Bank;
use App\Card\Status;

/* Controller Help methods. */
trait InitCardHelpers
{
    /**
     * Initializes the deck in the session if it doesn't already exist.
     *
     * @param SessionInterface $session The session instance to store the deck.
     */
    private function initDeck(SessionInterface $session): void
    {
        if ($session->get('deck') === null) {
            $deck = new DeckOfCards();
            $deck->createDeck();
            $deck->shuffleCards();
            $session->set('deck', $deck);
        }
    }

    /**
     * Initializes the player's hand in the session if it doesn't already exist.
     *
     * @param SessionInterface $session The session instance to store the player's hand.
     */
    private function initHandPlayer(SessionInterface $session): void
    {
        if ($session->get('hand_player') === null) {
            $handPlayer = new CardHand();
            $session->set('hand_player', $handPlayer);
        }
    }

    /**
     * Initializes the bank's hand in the session if it doesn't already exist.
     *
     * @param SessionInterface $session The session instance to store the bank's hand.
     */
    private function initHandBank(SessionInterface $session): void
    {
        if ($session->get('hand_bank') === null) {
            $handBank = new CardHand();
            $session->set('hand_bank', $handBank);
        }
    }

    /**
     * Initializes the player in the session if they don't already exist.
     *
     * @param SessionInterface $session The session instance to store the player.
     */
    private function initPlayer(SessionInterface $session): void
    {
        if ($session->get('player') === null) {
            $player = new Player();
            $session->set('player', $player);
        }
    }

    /**
     * Initializes the bank in the session if it doesn't already exist.
     *
     * @param SessionInterface $session The session instance to store the bank.
     */
    private function initBank(SessionInterface $session): void
    {
        if ($session->get('bank') === null) {
            $bank = new Bank();
            $session->set('bank', $bank);
        }
    }

    // /**
    //  * Handles the player's card draw from the deck and updates the player's hand in the session.
    //  *
    //  * @param SessionInterface $session The session instance to retrieve and store data.
    //  * @return array{cards: string, points: int} An array containing the formatted card
    //  * and updated points of the player's hand.
    //  */
    // private function handlePlayerDraw(SessionInterface $session): array
    // {
    //     /** @var \App\Card\DeckOfCards|null $deck */
    //     $deck = $session->get('deck');

    //     /** @var \App\Card\CardHand|null $handPlayer */
    //     $handPlayer = $session->get('hand_player');

    //     /** @var \App\Card\Player|null $player */
    //     $player = $session->get('player');

    //     // Kontrollerar om något objekt är null (phpstan)
    //     if (!$deck || !$handPlayer || !$player) {
    //         return ['cards' => 'No cards', 'points' => 0];
    //     }

    //     // Drar ett kort från DeckOfCards
    //     $card = $deck->drawCard();

    //     // Kontrollerar att kortet inte är null innan det används (phpstan)
    //     if (!$card) {
    //         return ['cards' => 'No cards', 'points' => 0];
    //     }

    //     $formatedCard = $deck->getCardAsString($card);

    //     // Lägger till kortet i handen
    //     $handPlayer->addCard($card);

    //     $player->play($handPlayer);

    //     // Uppdaterar session
    //     $session->set('hand_player', $handPlayer);
    //     $session->set('deck', $deck);
    //     $session->set('player', $player);

    //     $data = [
    //         'cards' => $formatedCard,
    //         'points' => $handPlayer->getPoints(),
    //     ];

    //     return $data;
    // }

    /**
     * Handles the player's card draw from the deck and updates the player's hand in the session.
     *
     * @param SessionInterface $session The session instance to retrieve and store data.
     * @return array{cards: string, points: int} An array containing the formatted card
     * and updated points of the player's hand.
     */
    private function handlePlayerDraw(SessionInterface $session): array
    {
        $game = $this->getGameObjectsFromSession($session);

        if (!$game) {
            return [
                'cards' => 'No cards',
                'points' => 0
            ];
        }

        [$deck, $handPlayer, $player] = $game;

        $card = $deck->drawCard();

        if (!$card) {
            return [
                'cards' => 'No cards',
                'points' => 0
            ];
        }

        $formatedCard = $deck->getCardAsString($card);
        $handPlayer->addCard($card);
        $player->play($handPlayer);

        $session->set('hand_player', $handPlayer);
        $session->set('deck', $deck);
        $session->set('player', $player);

        return [
            'cards' => $formatedCard,
            'points' => $handPlayer->getPoints(),
        ];
    }

    /**
     * Retrieves and validates deck, player hand, and player from the session.
     *
     * @param SessionInterface $session
     * @return array{DeckOfCards,CardHand,Player}|null
     */
    private function getGameObjectsFromSession(SessionInterface $session): ?array
    {
        /** @var \App\Card\DeckOfCards|null $deck */
        $deck = $session->get('deck');

        /** @var \App\Card\CardHand|null $handPlayer */
        $handPlayer = $session->get('hand_player');

        /** @var \App\Card\Player|null $player */
        $player = $session->get('player');

        if (!$deck || !$handPlayer || !$player) {
            return null;
        }

        return [$deck, $handPlayer, $player];
    }


    /**
     * Handles the bank's card draw process until it reaches 17 or more points and updates the session.
     *
     * @param SessionInterface $session The session instance to retrieve and store data.
     * @return array{cards: string, points: int, status: string} An array containing the
     * formatted cards, the bank's points, and its status.
     */
    private function handleBankDraw(SessionInterface $session): array
    {
        /** @var \App\Card\DeckOfCards $deck */
        $deck = $session->get('deck');

        /** @var \App\Card\CardHand $handBank */
        $handBank = $session->get('hand_bank');

        /** @var \App\Card\Bank $bank */
        $bank = $session->get('bank');

        // Banken drar tills den når 17 eller mer.
        while ($bank->isPlaying()) {
            $card = $deck->drawCard();
            if ($card) { // phpstan
                $handBank->addCard($card);
            }

            $bank->play($handBank);

            if ($bank->shouldStop()) {
                $bank->stop();
            }
        }

        $status = $bank->checkstatus();

        // Uppdaterar session
        $session->set('hand_bank', $handBank);
        $session->set('deck', $deck);
        $session->set('bank', $bank);

        $data = [
            'cards' => $handBank->getCardsAsString(),
            'points' => $handBank->getPoints(),
            'status' => $status,
        ];

        return $data;
    }

    /**
     * Ends the game and determines the winner based on the final status of the player and bank.
     *
     * @param SessionInterface $session The session instance to retrieve player and bank data.
     * @return string The result of the game, either the winner's name or an error message.
     */
    private function endGame(SessionInterface $session): string
    {
        /** @var \App\Card\Player $player */
        $player = $session->get('player');

        /** @var \App\Card\Bank $bank */
        $bank = $session->get('bank');

        $finalStatus = new Status($player, $bank);

        return $finalStatus->winner();

    }
}
