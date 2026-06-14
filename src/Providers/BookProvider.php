<?php

namespace App\Providers;

use App\Repository\BookRepository;
use App\Services\Books\BookSerializer;
use App\Domain\Books\DVO\Book;
use App\Domain\Books\Contract\BookProviderInterface;
use App\Domain\Books\Contract\Exception\BookNotFoundException;

class BookProvider implements BookProviderInterface
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly BookSerializer $bookSerializer
    ) {
    }

    public function getAll(): array
    {
        return array_map(
            function ($book) {
                return $this->bookSerializer->toDto($book);
            },
            $this->bookRepository->findAll(),
        );
    }

    public function save(Book $book): Book
    {
        $this->bookRepository->save($this->bookSerializer->toEntity($book));

        return $book;
    }

    public function getNbOfBooks(): int
    {
        return $this->bookRepository->countAll();
    }

    public function getNbOfPages(): int
    {
        return $this->bookRepository->sumAllPages();
    }

    public function getPage(int $page): array
    {
        return array_map(
            function ($book) {
                return $this->bookSerializer->toDto($book);
            },
            $this->bookRepository->findPagined($page)
        );
    }

    public function getByIsbn13(string $isbn13): Book
    {
        if ($book = $this->bookRepository->findOneByIsbn13($isbn13)) {
            return $this->bookSerializer->toDto($book);        
        }

        throw new BookNotFoundException();
    }
}
