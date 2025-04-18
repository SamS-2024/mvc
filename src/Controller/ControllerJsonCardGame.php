<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJsonCardGame extends AbstractController
{

    #[Route("api/deck", name: "api-deck")]
public function apiDeck(): Response
{
    $deck = new DeckOfCards();
    // Skapar kortleken och lagrar den i objektet
    $deck->createDeck();

    // Hämta korten i JSON-format
    $data = ['deck' => $deck->getAsJson()];

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
