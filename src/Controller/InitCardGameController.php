<?php

namespace App\Controller;

use App\Controller\InitCardHelpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class InitCardGameController extends AbstractController
{
    // Inkluderar hjälpfunktioner från en trait för att initiera och hantera kortspelet.
    use InitCardHelpers;

    // Visar startsidan för spelet.
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        // Rendera Twig-mallen för spelet.
        return $this->render('Cards/game.html.twig');
    }
    // Visar spelets dokumentationssida.
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('Cards/game-doc.html.twig');
    }
    // Startar spelet och initierar alla nödvändiga session-objekt.
    #[Route("/game/init", name: "init_game")]
    public function initGame(SessionInterface $session): Response
    {

        $this->initDeck($session);
        $this->initHandPlayer($session);
        $this->initHandBank($session);
        $this->initPlayer($session);
        $this->initBank($session);

        // Renderar spelsidan med initiala tomma värden och sätter spelarens tur.
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
    // Spelaren drar ett kort.
    #[Route("/game/init/draw", name: "init_game_draw", methods: ['POST'])]
    public function initGamePost(SessionInterface $session): Response
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player'); // Hämtar spelarens tillstånd

        if ($player && $player->isPlaying()) {
            $data = $this->handlePlayerDraw($session);

            // Lägger till status till data-arrayen
            $data['status'] = $player->checkStatus();

            // Renderar sidan med uppdaterad spelardata efter att spelaren dragit ett kort.
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
        $this->stopPlayer($session);
        $this->playBank($session);

        $finalResult = $this->endGame($session);
        $session->set('final_result', $finalResult);

        return $this->redirectToRoute('init_game_result');
    }

    private function stopPlayer(SessionInterface $session): void
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player');
        if ($player && $player->getPoints() > 0) {
            $player->stop();
        }
    }

    private function playBank(SessionInterface $session): void
    {
        /** @var \App\Card\Bank|null $bank */
        $bank = $session->get('bank');
        if ($bank && $bank->isPlaying()) {
            $this->handleBankDraw($session);
        }
    }

    // Visar slutresultatet efter att spelet är avslutat.
    #[Route("/game/init/result", name: "init_game_result", methods: ['GET'])]
    public function initGameResult(SessionInterface $session): Response
    {
        /** @var \App\Card\Player|null $player */
        $player = $session->get('player'); // Hämtar spelarens tillstånd

        /** @var \App\Card\Bank|null $bank */
        $bank = $session->get('bank'); // Hämtar bankens tillstånd

        // Om spelare eller bank saknas, starta om spelet
        if (!$player || !$bank) { //(phpstan)
            return $this->redirectToRoute('init_game');
        }

        // Förbereder data för spelare och bank för att visa på sidan
        $data = $this->preparePlayerData($player);
        $dataBank = $this->preparePlayerData($bank);

        // Hämtar det slutgiltiga resultatet från sessionen
        $finalResult = $session->get('final_result');

        // Renderar vyn med speldata, bankdata och resultat
        return $this->render('Cards/init-game.html.twig', [
            'data' => $data,
            'dataBank' => $dataBank,
            'turn' => 'end',
            'finalResult' => $finalResult,
        ]);
    }

    // Nollställer spelets tillstånd för en ny spelrunda.
    #[Route("/game/reset", name: "game_reset", methods: ['POST'])]
    public function newGameRound(SessionInterface $session): Response
    {
        // Tar bort spelare, bank, kortlek och händer från sessionen
        $session->remove('player');
        $session->remove('bank');
        $session->remove('deck');
        $session->remove('hand_player');
        $session->remove('hand_bank');
        $session->remove('final_result'); // Tar även bort tidigare resultat

        // Omdirigerar till initiering av nytt spel
        return $this->redirectToRoute('init_game');
    }

    /**
     * Prepares player data for rendering in the view.
     * Returns an associative array containing the player's hand as a string,
     * current points, and status.
     *
     * @param \App\Card\Player|\App\Card\Bank $player
     * @return array<string, string|int>
    */
    public function preparePlayerData($player): array
    {
        return [
            // Kort i handen som sträng
            'cards' => $player->getHand()->getCardsAsString(),
            // Aktuella poäng
            'points' => $player->getPoints(),
            // Spelarens status (t.ex. "stopped", "busted")
            'status' => $player->checkStatus(),
        ];
    }

}
