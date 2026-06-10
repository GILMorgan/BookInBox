<?php

namespace App\Providers;

use App\Repository\AuthorRepository;
use App\Services\Books\AuthorSerializer;
use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\DTO\Author;
use App\Providers\Exception\AuthorNotFoundException;

class AuthorProvider implements AuthorProviderInterface
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    public function save(Author $author): Author
    {
        $this->authorRepository->save(
            AuthorSerializer::toEntity($author)
        );

        return $author;
    }

    public function delete(Author $author): void
    {
        $entity = $this->authorRepository->find($author->id);

        $this->authorRepository->delete($entity);
    }

    public function get(string $id): Author
    {
        return $this->authorSerializer->toDto(
            $this->authorRepository->find($id)
        );
    }

    public function getAll(): array
    {
        return array_map(
            function ($author) {
                return AuthorSerializer::toDto($author);
            },
            $this->authorRepository->findAll()
        );
    }

    public function getByGoodreadId(string $goodreadId): Author
    {
        $author =  $this->authorRepository->findOneByGoodreadId($goodreadId);

        if (!$author) {
            throw new AuthorNotFoundException(
                sprintf(
                    "Couldn't find author with the goodread id %s",
                    $goodreadId
                )
            );
        }

        return AuthorSerializer::toDto($author);    
    }

    public function getNbOfAuthors(): int
    {
        return $this->authorRepository->countAll();
    }

    public function getPage(int $page): array
    {
        return array_map(
            function ($author) {
                return AuthorSerializer::toDto($author);
            },
            $this->authorRepository->findPagined($page)
        );
    }

    public function findByName(string $name): array
    {
        return array_map(
            function ($author) {
                return AuthorSerializer::toDto($author);
            },
            $this->authorRepository->findByName($name)
        ); 
    } 
} 
