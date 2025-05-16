<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ControllerJsonLibrary extends AbstractController
{
    #[Route('/api/library/books', name: 'app_library-json')]
    public function showAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/book/{isbn}', name: 'api_book_by_isbn')]
    public function showBookByIsbn(
        BookRepository $bookRepository,
        string $isbn
    ): Response {

        // En metod som hämtar en post baserat på valfritt fält.
        $book = $bookRepository->findOneBy(
            ['isbn' => $isbn]
        );

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
