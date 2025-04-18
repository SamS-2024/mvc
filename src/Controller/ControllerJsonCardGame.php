<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJsonCardGame extends AbstractController
{

    #[Route("api/deck", name: "api-deck", methods: ["GET"])]
    public function apiDeck(): Response
    {
        $deck = new DeckOfCards();
        // Skapar kortleken och lagrar den i objektet
        $deck->createDeck();

        // Hämta korten i JSON-format
        $data = [
            'deck' => $deck->getAsJson()];

        $response = $this->responseHelper($data);
        return $response;
    }


    #[Route("api/deck/shuffle", name: "api-deck-shuffle-get", methods: ["GET"])]
    public function viewShuffleForm(): Response
    {
        return $this->render('Cards/json_form.html.twig');
    }


    #[Route("api/deck/draw", name: "api-deck-draw-get", methods: ["GET"])]
    public function apiDeckDrawForm(): Response
    {
        return $this->render('Cards/json_form.html.twig');
    }


    #[Route("api/deck/shuffle", name: "api-deck-shuffle", methods: ["POST"])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
    $deck = new DeckOfCards();
    $deck->createDeck();
    $deck->shuffleCards();

    $session->set("shuffled_cards_json", $deck->getAsJson());

    $data = ['deck' => $deck->getAsJson()];
    $response = $this->responseHelper($data);

    return $response;
}

    #[Route("api/deck/draw", name: "api-deck-draw", methods: ["POST"])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        $cards = $session->get("shuffled_cards_json");

        $drawCard = array_pop($cards);

        $session->set("shuffled_cards_json", $cards);

        $data = [
            'deck' => $drawCard,
            "remainingCards" => count($cards)
        ];

        $response = $this->responseHelper($data);
        return $response;
    }


    private function responseHelper(array $data): JsonResponse
    {
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
