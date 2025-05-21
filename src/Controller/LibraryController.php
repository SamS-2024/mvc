<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    use LibraryHelpers;

    #[Route('/library', name: 'app_library')]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('library/index.html.twig', [
            'books' => $this->getAllBooks($bookRepository),
        ]);
    }

    #[Route('/library/create', name: 'show-create-form', methods: ['GET'])]
    public function showCreateForm(): Response
    {
        return $this->render('library/create.html.twig');
    }

    #[Route('/library/create', name: 'library_create', methods: ['POST'])]
    public function createBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();

        $this->fillBookData($book, $request);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library');
    }

    #[Route('/library/find', name: 'find_book_form')]
    public function findBookForm(): Response
    {
        return $this->render('library/find-book.html.twig');
    }

    #[Route('/library/find-id', name: 'find_book_by_id', methods: ['GET'])]
    public function findBookById(Request $request): Response
    {
        $id = $request->query->get('id');

        return $this->redirectToRoute('show_book_by_id', ['id' => $id]);
    }

    #[Route('/library/show/{id<\d+>}', name: 'show_book_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        return $this->render('library/show-book.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/list', name: 'book-list')]
    public function bookLinks(BookRepository $bookRepository): Response
    {
        return $this->render('library/book-table.html.twig', [
            'books' => $this->getAllBooks($bookRepository),
        ]);
    }

    #[Route('/library/show/update', name: 'show_update_form')]
    public function showUpdateForm(Request $request): Response
    {
        $id = $request->query->get('id');
        if ($id) {
            return $this->redirectToRoute('show-book-to-update', ['id' => $id]);
        }

        return $this->render('library/show-update-form.html.twig');
    }

    #[Route('/library/update/{id<\d+>}', name: 'show-book-to-update', methods: ['GET'])]
    public function findBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException("No book with id $id is found.");
        }

        return $this->render('library/update-form.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/library/update', name: 'book_update', methods: ['POST'])]
    public function updateBook(
        Request $request,
        BookRepository $bookRepository,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('id');
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException("No book with id $id is found.");
        }

        $this->fillBookData($book, $request);

        $entityManager->flush();

        return $this->redirectToRoute('app_library');
    }

    #[Route('/library/delete/{id<\d+>}', name: 'book_delete_by_id')]
    public function deleteProductById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library');
    }

    // /**
    //  * Populates a Book object with data from an HTTP request.
    //  * Used for both creating and updating books.
    //  *
    //  * @param Book $book The Book entity to populate.
    //  * @param Request $request The HTTP request containing form data.
    //  */
    // private function fillBookData(Book $book, Request $request): void
    // {
    //     $book->setTitle((string) $request->request->get('title'));
    //     $book->setIsbn((string) $request->request->get('isbn'));
    //     $book->setAuthor((string) $request->request->get('author'));
    //     $book->setImage((string) $request->request->get('image'));
    // }

    /**
     * Retrieves all Book entities from the repository.
     *
     * @param BookRepository $bookRepository The repository to fetch books from.
     * @return Book[] An array of Book objects.
     */
    private function getAllBooks(BookRepository $bookRepository): array
    {
        return $bookRepository->findAll();
    }
}
