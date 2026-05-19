<?php

namespace App\Controller\Books;

use App\Domain\Books\Contract\AuthorProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class AuthorsController extends AbstractController
{
    public function __construct(
        private readonly AuthorProviderInterface $authorProvider
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
        $page = (int) $request->query->get('page', 1);
        $nbAuthors = $this->authorProvider->getNbOfAuthors();
        $authors = $this->authorProvider->getPage($page);

        return new JsonResponse(
            [
            "nbAuthors" => $nbAuthors,
            "authors" => $authors,
            ]
        ); 
    }

    #[Route('/api/authors/find', name: 'app_api_authors_find')]
    public function findAuthors(Request $request): Response
    {
        $postValues = json_decode($request->getContent(), true);        

        if (!isset($postValues['name'])) {
            throw new \Exception("malformed query");
        }

        return new JsonResponse(
            $this->authorProvider->findByName($postValues['name'])
        );
    }
}
