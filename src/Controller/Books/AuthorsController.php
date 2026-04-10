<?php

namespace App\Controller\Books;

use App\Domain\Books\Contract\AuthorProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorsController extends AbstractController
{
    public function __construct(
        private readonly AuthorProviderInterface $authorProvider
    ){    
    }

    #[Route('/books/authors', name: 'app_books_authors')]
    public function index(): Response
    {
        return $this->render('books/authors/index.html.twig', [
            "authors" => $this->authorProvider->getAll(),       
        ]);
    }
}
