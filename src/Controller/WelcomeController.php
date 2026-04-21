<?php

namespace App\Controller;

use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\Contract\BookProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WelcomeController extends AbstractController
{
    public function __construct(
        private readonly AuthorProviderInterface $authorProvider,
        private readonly BookProviderInterface $bookProvider
    ) {
    }

    #[Route('/', name: 'app_welcome')]
    public function index(): Response
    {
        return $this->render(
            "welcome.html.twig",
            [
                "nbAuthors" => $this->authorProvider->getNbOfAuthors(),
                "nbBooks" => $this->bookProvider->getNbOfBooks(),
                "nbPages" => $this->bookProvider->getnbOfPages(),
            ]
        );
    }
}
