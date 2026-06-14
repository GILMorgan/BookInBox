<?php

namespace App\Controller\Books;

use App\Domain\Books\DTO\GetAuthorPageParams;
use App\Domain\Books\DTO\SearchAuthorParams;
use App\Domain\Books\Controller\GetAuthorPage;
use App\Domain\Books\Controller\SearchAuthor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class AuthorsController extends AbstractController
{
    public function __construct(
        private readonly GetAuthorPage $getAuthorPage,
        private readonly SearchAuthor $searchAuthor
    ) {    
    }

    #[Route('/books/authors', name: 'app_books_authors')]
    public function index(): Response
    {
        return $this->render('books/authors/index.html.twig');
    }

    #[Route('/api/authors', name: 'app_api_authors')]
    public function getAuthors(Request $request): Response
    {
        return new JsonResponse(
            $this->getAuthorPage->getAuthorPage(
                new GetAuthorPageParams((int) $request->query->get('page', 1))
            )
        );
    }

    #[Route('/api/authors/find', name: 'app_api_authors_find')]
    public function findAuthors(Request $request): Response
    {
        $postValues = json_decode($request->getContent(), true);        

        if (!isset($postValues['name'])) {
            throw new \Exception("malformed query");
        }

        $result = $this->searchAuthor->searchAuthor(new SearchAuthorParams($postValues['name']));

        return new JsonResponse(
            $result->authors
        );
    }
}
