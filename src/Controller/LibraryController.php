<?php

namespace App\Controller;
use App\Entity\Book;
// use Doctrine\ORM\Mapping\PostPersist;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
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

        dump($book);


        return new Response('Saved new book with id ' . $book->getId());
    }
}
