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
        $this->authorRepository->save(
            $this->authorSerializer->toEntity($author)
        );

        return $author;
    }

    public function delete(Author $author): void
    {
        $entity = $this->authorRepository->find($author->id);

        $this->authorRepository->delete($entity);
    }

    public function getAll(): array
    {
        return array_map(
            function ($author) {
                return $this->authorSerializer->toDto($author);
            },
            $this->authorRepository->findAll()
        );
    }
} 
