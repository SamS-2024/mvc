<?php

namespace App\Controller;

use App\Card\Bank;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Player;
use App\Card\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class InitCardGameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {

        return $this->render('Cards/game.html.twig');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('Cards/game-doc.html.twig');
    }

    #[Route("/game/init", name: "init_game")]
    public function initGame(SessionInterface $session): Response
    {

        $this->initDeck($session);
        $this->initHandPlayer($session);
        $this->initHandBank($session);
        $this->initPlayer($session);
        $this->initBank($session);

        return $this->render('Cards/init-game.html.twig', [
            'data' => [
                'cards' => '',
                'points' => 0,
                'status' => '',
            ],
            'dataBank' => [
                'cards' => '',
                'points' => 0,
                'status' => '',
            ],
            'turn' => 'player'
        ]);
    }

    #[Route("/game/init/draw", name: "init_game_draw", methods: ['POST'])]
    public function initGamePost(SessionInterface $session): Response
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player'); // Hämtar spelarens tillstånd

        if ($player && $player->isPlaying()) {
            $data = $this->handlePlayerDraw($session);

            // Lägger till status till data-arrayen
            $data['status'] = $player->checkStatus();
            return $this->render('Cards/init-game.html.twig', [
                'data' => $data,
                'turn' => 'player'
            ]);
        }

        // Om spelaren inte är i spel (har stannat), låter banken spela
        $dataBank = $this->handleBankDraw($session);

        return $this->render('Cards/init-game.html.twig', [
            'dataBank' => $dataBank,
            'turn' => 'bank'
        ]);
    }

    #[Route("/game/init/stop", name: "init_game_stop", methods: ['POST'])]
    public function initGameStop(SessionInterface $session): Response
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player');
        if ($player && $player->getPoints() > 0) {
            $player->stop();
        }

        /** @var \App\Card\Bank|null $bank */
        $bank = $session->get('bank');

        if ($bank && $bank->isPlaying()) {
            $this->handleBankDraw($session);
        }

        $finalResult = $this->endGame($session);
        $session->set('final_result', $finalResult);

        return $this->redirectToRoute('init_game_result');
    }

    #[Route("/game/init/result", name: "init_game_result", methods: ['GET'])]
    public function initGameResult(SessionInterface $session): Response
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player');

        /** @var \App\Card\Bank|null $bank */
        $bank = $session->get('bank');

        if (!$player || !$bank) { //(phpstan)
            return $this->redirectToRoute('init_game');
        }

        $data = [
            'cards' => $player->getHand()->getCardsAsString(),
            'points' => $player->getPoints(),
            'status' => $player->checkStatus(),
        ];

        $dataBank = [
            'cards' => $bank->getHand()->getCardsAsString(),
            'points' => $bank->getPoints(),
            'status' => $bank->checkStatus(),
        ];

        $finalResult = $session->get('final_result');

        return $this->render('Cards/init-game.html.twig', [
            'data' => $data,
            'dataBank' => $dataBank,
            'turn' => 'end',
            'finalResult' => $finalResult,
        ]);
    }

    #[Route("/game/reset", name: "game_reset", methods: ['POST'])]
    public function newGameRound(SessionInterface $session): Response
    {
        $session->remove('player');
        $session->remove('bank');
        $session->remove('deck');
        $session->remove('hand_player');
        $session->remove('hand_bank');
        $session->remove('final_result');


        return $this->redirectToRoute('init_game');
    }

    /* Controller Help methods. */

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

    /**
     * Handles the player's card draw from the deck and updates the player's hand in the session.
     *
     * @param SessionInterface $session The session instance to retrieve and store data.
     * @return array{cards: string, points: int} An array containing the formatted card
     * and updated points of the player's hand.
     */
    private function handlePlayerDraw(SessionInterface $session): array
    {
        /** @var \App\Card\DeckOfCards|null $deck */
        $deck = $session->get('deck');

        /** @var \App\Card\CardHand|null $handPlayer */
        $handPlayer = $session->get('hand_player');

        /** @var \App\Card\Player|null $player */
        $player = $session->get('player');

        // Kontrollerar om något objekt är null (phpstan)
        if (!$deck || !$handPlayer || !$player) {
            return ['cards' => 'No cards', 'points' => 0];
        }

        // Drar ett kort från DeckOfCards
        $card = $deck->drawCard();

        // Kontrollerar att kortet inte är null innan det används (phpstan)
        if (!$card) {
            return ['cards' => 'No cards', 'points' => 0];
        }

        $formatedCard = $deck->getCardAsString($card);

        // Lägger till kortet i handen
        $handPlayer->addCard($card);

        $player->play($handPlayer);

        // Uppdaterar session
        $session->set('hand_player', $handPlayer);
        $session->set('deck', $deck);
        $session->set('player', $player);

        $data = [
            'cards' => $formatedCard,
            'points' => $handPlayer->getPoints(),
        ];

        return $data;
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
