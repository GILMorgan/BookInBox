<?php

namespace App\Providers;

use App\Repository\AuthorRepository;
use App\Services\Books\AuthorSerializer;
use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\DTO\Author;

class AuthorProvider implements AuthorProviderInterface
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly AuthorSerializer $authorSerializer
    ) {
    
    }

    public function save(Author $author): Author
    {
        return Author;
    }

    public function delete(Author $author): void
    {
    
    }
} 
