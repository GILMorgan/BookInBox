<?php

namespace App\Controller\Books;

use App\Providers\BookProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class BooksController extends AbstractController
{
    public function __construct(
        private readonly BookProvider $bookProvider
    ) {
    }

    #[Route('/books/books', name: 'app_books_books')]
    public function index(): Response
    {
        return $this->render(
            'books/books/index.html.twig', [
            "books" => $this->bookProvider->getAll(),
            ]
        );
    }

    #[Route('/api/books', name: 'app_api_books')]
    public function getBooks(Request $request): Response
    {
        $page = (int) $request->query->get('page');
        $books = $this->bookProvider->getPage($page);
        $nbBooks = $this->bookProvider->getNbOfBooks();

        return new JsonResponse([
            "books" => $books,
            "nbBooks" => $nbBooks,
        ]);
    }
}
