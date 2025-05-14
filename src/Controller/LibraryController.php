<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
// use Doctrine\ORM\Mapping\PostPersist;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(BookRepository $bookRepository): Response
    {

        $books = $bookRepository
            ->findAll();

        return $this->render('library/index.html.twig', [
            'books' => $books
        ]);
    }

    #[Route('/library/create', name: 'show-create-form', methods: ['GET'])]
    public function showCreateForm()
    {
        return $this->render('library/create.html.twig');
    }

    #[Route('/library/create', name: 'library_create', methods: ['POST'])]
    public function createBook(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $book = new Book();

        $book->setTitle($request->request->get('title'));
        $book->setIsbn($request->request->get('isbn'));
        $book->setAuthor($request->request->get('author'));
        $book->setImage($request->request->get('image'));

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Saved new book with id ' . $book->getId());
    }

    #[Route('/library/show/{id}', name: 'show_book_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->render('library/show-book.html.twig', [
            'book' => $book
        ]);
    }
    // Tabell för att visa titel och länka till mer info.
    #[Route('/library/links', name: 'book-links')]
    public function bookLinks(
        BookRepository $bookRepository,
    ): Response {
        $books = $bookRepository
            ->findAll();

        return $this->render('library/book-table.html.twig', [
            'books' => $books
        ]);
    }

    // #[Route('/library/update/{id}', name: 'product_update')]
    // public function updateProduct(
    //     ManagerRegistry $doctrine,
    //     int $id,
    //     int $value
    // ): Response {
    //     $entityManager = $doctrine->getManager();
    //     $product = $entityManager->getRepository(Product::class)->find($id);

    //     if (!$product) {
    //         throw $this->createNotFoundException(
    //             'No product found for id '.$id
    //         );
    //     }

    //     $product->setValue($value);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('product_show_all');
    // }
}
