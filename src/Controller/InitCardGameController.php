<?php

namespace App\Controller;


use App\Card\Bank;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Player;
use App\Card\Status;
use Exception;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class InitCardGameController extends AbstractController
{

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

    #[Route("/game/init/draw", name: "init_game_draw", methods: ['POST'] )]
    public function initGamePost(SessionInterface $session): Response
    {
    // Hämtar spelarens tillstånd
    $player = $session->get('player');

    if ($player->isPlaying()) {
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

    #[Route("/game/init/stop", name: "init_game_stop", methods: ['POST'] )]
    public function initGameStop(SessionInterface $session): Response
    {
        $player = $session->get('player');
        $player->stop();

        $bank = $session->get('bank');

        if ($bank->isPlaying()) {
            $this->handleBankDraw($session);
        }

        $finalResult = $this->endGame($session);
        $session->set('final_result', $finalResult);

        return $this->redirectToRoute('init_game_result');
    }

    #[Route("/game/init/result", name: "init_game_result", methods: ['GET'] )]
    public function initGameResult(SessionInterface $session): Response
    {
        $player = $session->get('player');
        $bank = $session->get('bank');

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

    #[Route("/game/reset", name: "game_reset", methods: ['POST'] )]
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



    private function endGame(SessionInterface $session): string {
        $player = $session->get('player');
        $bank = $session->get('bank');
        if ($player && $bank) {
            $finalStatus = new Status($player, $bank);
            // $session->set('final_status', $finalStatus);
            var_dump($finalStatus->winner()); // Debugg!!!
            return $finalStatus->winner();
        }

        // Om player eller bank saknas, returneras en sträng som ett felmeddelande
        return 'Error: Missing player or bank data';
    }


    private function handlePlayerDraw(SessionInterface $session): array {
        $deck = $session->get('deck');
        $handPlayer = $session->get('hand_player');
        $player = $session->get('player');

        // Drar ett kort från DeckOfCards
        $card = $deck->drawCard();
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

    private function handleBankDraw(SessionInterface $session): array {
        $deck = $session->get('deck');
        $handBank = $session->get('hand_bank');
        $bank = $session->get('bank');

        // Banken drar tills den når 17 eller mer.
        while ($bank->isPlaying()) {
            $card = $deck->drawCard();
            $handBank->addCard($card);
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


    // Hjälpmetoderna
    private function initDeck(SessionInterface $session): void
    {
        if ($session->get('deck') === null) {
            $deck = new DeckOfCards();
            $deck->createDeck();
            $deck->shuffleCards();
            $session->set('deck', $deck);
        }
    }

    private function initHandPlayer(SessionInterface $session): void
    {
        if ($session->get('hand_player') === null) {
            $handPlayer = new CardHand();
            $session->set('hand_player', $handPlayer);
        }
    }

    private function initHandBank(SessionInterface $session): void
    {
        if ($session->get('hand_bank') === null) {
            $handBank = new CardHand();
            $session->set('hand_bank', $handBank);
        }
    }


    private function initPlayer(SessionInterface $session): void {
        if ($session->get('player') === null) {
            $player = new Player;
            $session->set('player', $player);
        }
    }

    private function initBank(SessionInterface $session): void {
        if ($session->get('bank') === null) {
            $bank = new Bank;
            $session->set('bank', $bank);
        }
    }

}
