<?php

namespace App\Controller\Books;

use App\Providers\BookProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BooksController extends AbstractController
{
    public function __construct(
        private readonly BookProvider $bookProvider
    ) {
    }

    #[Route('/books/books', name: 'app_books_books')]
    public function index(): Response
    {
        return $this->render('books/books/index.html.twig', [
            "books" => $this->bookProvider->getAll(),
        ]);
    }
}
