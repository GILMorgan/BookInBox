<?php

namespace App\Twig;

use App\Domain\Books\Dto\Book;
use App\Domain\Books\Contract\AuthorProviderInterface;

use Twig\Attribute\AsTwigFunction;
class BooksAuthor
{
    public function __construct(private readonly AuthorProviderInterface $authorProvider)
    {
    
    }

    #[AsTwigFunction('booksAuthor')]
    public function booksAuthor(Book $book): string
    {
        $authors = array_map(
            function ($author) {                
                return $this->authorProvider->get($author)->name;  
            },
            $book->authors
        );

        return implode(',', $authors);
    }
}
