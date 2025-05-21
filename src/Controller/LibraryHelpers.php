<?php
namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait LibraryHelpers
 *
 * Provides utility methods for handling Book entity data.
 */
// @phpstan-ignore-next-line
trait LibraryHelpers
{
    /**
     * Populate a Book entity with data from an HTTP request.
     *
     * This method extracts the title, ISBN, author, and image fields
     * from the POST request and sets them on the given Book entity.
     *
     * @param Book $book The Book entity to populate.
     * @param Request $request The HTTP request containing form data.
     */
    private function fillBookData(Book $book, Request $request): void
    {
        $book->setTitle((string) $request->request->get('title'));
        $book->setIsbn((string) $request->request->get('isbn'));
        $book->setAuthor((string) $request->request->get('author'));
        $book->setImage((string) $request->request->get('image'));
    }
}
