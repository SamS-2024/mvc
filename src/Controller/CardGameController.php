<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
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

        $deck = new DeckOfCards();
        $deck->createDeck();
        $shuffledCards = $deck->shuffleCards();

        $session->set("deck", $deck);

        $data = [
            "cardString" => $deck->getAsString($shuffledCards)
        ];

        return $this->render('Cards/card-shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function drawCard(
        SessionInterface $session
    ): Response {

        /** @var \App\Card\Card[] $shuffledCards */
        $deck = $session->get("deck");

        if (!$deck || $deck->getRemainingCount() === 0) {

            return $this->redirectToRoute("card_shuffle");
        }

        $removedCard = $deck->drawCard();

        $count = $deck->getRemainingCount();

        // Använder CardGraphic genom DeckOfCards för att formatera kortet
        $symbol = $deck->getCardAsString($removedCard);

        // Uppdaterar sessionen
        $session->set("deck", $deck);

        $data = [
            "cardString" => $symbol,
            "remainigCards" => $count
        ];

        return $this->render('Cards/card-draw.html.twig', $data);
    }

    #[Route("card/deck/draw/{num<\d+>}", name: "draw_cards")]
    public function drawCards(
        int $num,
        SessionInterface $session
    ): Response {

        // Kollar om kortleken är tom innan anrop till hjälpfunktionen.
        $deck = $session->get("deck", []);

        if (!$deck || $deck->getRemainingCount() === 0 || $num > $deck->getRemainingCount()) {

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
        $deck = $session->get("deck");

        $removedCards = [];

        $removedCards = $deck->drawCards($num);

        $remainingCards = $deck->getRemainingCount();

        $session->set("deck", $deck);

        // $renderCards = new DeckOfCards();
        $cardString = $deck->getAsString($removedCards);

        $data = [
            "cardString" => $cardString,
            "remainigCards" => $remainingCards
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

    #[Route("/game", name: "game")]
    public function game(): Response
    {

        return $this->render('Cards/game.html.twig');
    }


    #[Route("/game/init", name: "init_game")]
    public function initGame(SessionInterface $session): Response
    {
        if ($session->get('deck') === null) {
            $deck = new DeckOfCards();
            $deck->createDeck();
            $deck->shuffleCards();
            $session->set('deck', $deck);
        }

        if ( $session->get('hand') === null) {
            $hand = new CardHand();
            $session->set('hand', $hand);
        }

        $data = [
            'cards' => '',
            'points' => 0
        ];

        return $this->render('Cards/init-game.html.twig', $data);
    }


#[Route("/game/init/draw", name: "init_game_draw", methods: ['POST'] )]
public function initGamePost(
    SessionInterface $session
): Response {
    $deck = $session->get('deck');
    $hand = $session->get('hand');

    // Drar ett kort från DeckOfCards
    $card = $deck->drawCard();
    $formatedCard = $deck->getCardAsString($card);

    // Lägg till kortet i handen
    $hand->addCard($card);

    // Uppdatera session
    $session->set('hand', $hand);
    $session->set('deck', $deck);

    // Hämta poängen från handen
    $points = $hand->getPoints();

    $data = [
        'cards' => $formatedCard,
        'points' => $points
    ];

    return $this->render('Cards/init-game.html.twig', $data);
}


}
