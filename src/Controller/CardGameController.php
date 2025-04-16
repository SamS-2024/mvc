<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response {

        return $this->render('Cards/card.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(): Response {
        $allCards = new CardGraphic();

        $data = [
            "spades"=>$allCards->getAsString($allCards->createSpades()),
            "hearts"=>$allCards->getAsString($allCards->createHearts()),
            "diamonds"=>$allCards->getAsString($allCards->createDiamonds()),
            "clubs"=>$allCards->getAsString($allCards->createClubs())
        ];
        return $this->render('Cards/card-deck.html.twig', $data);
    }

    #[Route("/test", name: "test_session")]
    public function sessionTest(
        SessionInterface $session
    ): Response {
        $session->set("test", "Hej jag är en session");
        $session->set("test2", "Hello, här är det ett annat test");

        return $this->redirectToRoute("show_session");
    }

    #[Route("/session", name: "show_session")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            "test" => $session->get("test"),
            "test2" => $session->get("test2")
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
