<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJson extends AbstractController
{

    #[Route("/api", name: "api-overview")]
    public function apiOverview(): Response
    {
        $data = [
            '/api' => 'Visar en sammanställning av alla JSON routes som din webbplats erbjuder.',
            '/api/quote' => 'Ger ett slumpmässigt JSON svar som innehåller dagens citat.',
        ];

        return $this->render('api-overview.html.twig', ['data' => $data]);
    }

    #[Route("/api/quote", name: "api-quote")]
    public function apiQuote(): Response
    {
        $quote1 = '"Fear is the path to the dark side. '
        . 'Fear leads to anger. '
        . 'Anger leads to hate. '
        . 'Hate leads to suffering." - Yoda';

        $quote2 = '"Intelligence is the ability to adapt to change." - Stephen Hawking';
        $quote3 = '"We are all now connected by the Internet, like neurons in a giant brain." '
        . '- Stephen Hawking';

        $quote4 = '"As you start to walk on the way, the way appears." - Rumi';
        $quote5 = '"It\'s amazing that the amount of news that happens in the '
        . 'world every day always just exactly fits the newspaper." - Jerry Seinfeld';

        $quotes = [$quote1, $quote2, $quote3, $quote4, $quote5];
        $randomQuotes = $quotes[array_rand($quotes)];
        // Sätter tidszonen så det blir rätt i studentservern.
        date_default_timezone_set('Europe/Stockholm');
        $data = [
            'randomQuotes' => $randomQuotes,
            'data' => date('Y-m-d H:i:s')
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
