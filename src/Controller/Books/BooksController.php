<?php

namespace App\Controller\Books;

use App\Domain\Books\Controller\GetBookPage;
use App\Domain\Books\DTO\GetBookPageParams;
use App\Providers\BookProvider;
use App\Providers\MyBookProvider;
use App\Services\Books\BookJson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class BooksController extends AbstractController
{
    public function __construct(
        private readonly BookProvider $bookProvider,
        private readonly MyBookProvider $myBookProvider,
        private readonly BookJson $bookJson,
        private readonly GetBookPage $getBookPage,
    ) {
    }

    #[Route('/books/books', name: 'app_books_books')]
    public function index(): Response
    {
        return $this->render('books/books/index.html.twig');
    }

    #[Route('/books/my-books', name: 'app_books_mybooks')]
    public function myBooks(): Response
    {
        return $this->render('books/books/my-books.html.twig');
    }

    #[Route('/api/books', name: 'app_api_books')]
    public function getBooks(Request $request): Response
    {
        return new JsonResponse(
            $this->getBookPage->getBookPage(
                new GetBookPageParams(
                    (int) $request->query->get('page', 1)
                )
            )
        );
    }

    #[Route('/api/my_book', name: 'app_api_my-books')]
    public function getMyBooks(Request $request): Response
    {
        $page = (int) $request->query->get('page', 1);
        $books = $this->myBookProvider->getPage($page);
        $nbBooks = $this->myBookProvider->getNbOfBooks();

        return new JsonResponse(
            [
                "books" => $books,
                "nbBooks" => $nbBooks,
            ]
        );
    }

    #[Route('/books/addBook', name: 'app_books_add')]
    public function addBookForm(): Response
    {
        return $this->render('books/books/add.html.twig');
    }

    #[Route('/api/books/add', name: 'app_api_books_add')]
    public function addBook(Request $request): Response
    {
        $book = $this->bookJson->toDto($request->getContent());

        $this->bookProvider->save($book);

        return new JsonResponse();
    }
}
