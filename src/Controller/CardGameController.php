<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardGraphic;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {

        return $this->render('Cards/card.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(): Response
    {

        $deck = new DeckOfCards();
        $cardArray = $deck->createDeck();
        $cards = $deck->getAsString($cardArray);

        $data = [
            "cards" => $cards
        ];

        return $this->render('Cards/card-deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffleCards(
        SessionInterface $session
    ): Response {

        $cards = new DeckOfCards();
        $cards->createDeck();
        $shuffledCards = $cards->shuffleCards();

        $session->set("shuffled_cards", $shuffledCards);

        $data = [
            "cardString" => $cards->getAsString($shuffledCards)
        ];

        return $this->render('Cards/card-shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function drawCard(
        SessionInterface $session
    ): Response {

        /** @var \App\Card\Card[] $shuffledCards */
        $shuffledCards = $session->get("shuffled_cards");

        if (empty($shuffledCards)) {

            return $this->redirectToRoute("card_shuffle");
        }

        $removedCard = array_pop($shuffledCards);

        // Använder CardGraphic för att formatera kortet
        $renderCard = new CardGraphic();
        $symbol = $renderCard->formatCard($removedCard);

        // Uppdaterar sessionen
        $session->set("shuffled_cards", $shuffledCards);

        $data = [
            "cardString" => $symbol,
            "remainigCards" => count($shuffledCards)
        ];

        return $this->render('Cards/card-draw.html.twig', $data);
    }

    #[Route("card/deck/draw/{num<\d+>}", name: "draw_cards")]
    public function drawCards(
        int $num,
        SessionInterface $session
    ): Response {

        // Kollar om kortleken är tom innan anrop till hjälpfunktionen.
        $shuffledCards = $session->get("shuffled_cards", []);

        if (empty($shuffledCards)) {

            return $this->redirectToRoute("card_shuffle");
        }

        $data = $this->drawCardsHelper($num, $session);

        return $this->render('Cards/draw-cards.html.twig', $data);
    }

    #[Route("card/deck/draw/num", name: "draw_cards_num_get", methods: ['GET'])]
    public function drawCardsGet(): Response
    {
        return $this->render('Cards/draw-cards-form.html.twig');
    }

    #[Route("card/deck/draw/num", name: "draw_cards_num_post", methods: ['POST'])]
    public function drawCardsPost(
        Request $request,
    ): Response {

        $numCards = $request->request->get('num_cards');

        return $this->redirectToRoute('draw_cards', ['num' => $numCards]);

    }

/**
 * Helper function to draw cards and prepare data for rendering.
 *
 * @param int $num The number of cards to draw.
 * @param SessionInterface $session The current session storing the shuffled deck.
 *
 * @return array{cardString: string, remainigCards: int}
 * An associative array with a string of cards and the count of remaining cards.
 */
    private function drawCardsHelper(
        int $num,
        SessionInterface $session
    ): array {
        if ($num > 52) {
            throw new Exception("Can not draw more than 52 cards!");
        }

        /** @var \App\Card\Card[] $shuffledCards */
        $shuffledCards = $session->get("shuffled_cards");

        $removedCards = [];
        $count = 0;

        while ($count < $num && !empty($shuffledCards)) {
            $removedCards[] = array_pop($shuffledCards);
            $count++;
        }

        $session->set("shuffled_cards", $shuffledCards);

        // Använder den nya metoden för att formatera korten
        $renderCards = new CardGraphic();
        $cardString = $renderCards->getAsString($removedCards);

        $data = [
            "cardString" => $cardString,
            "remainigCards" => count($shuffledCards)
        ];

        return $data;
    }


    #[Route("/session", name: "show_session")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            "session" => $session->all()
        ];

        return $this->render('Cards/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(
        SessionInterface $session
    ): Response {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session is deleted!'
        );

        return $this->redirectToRoute('show_session');
    }
}
