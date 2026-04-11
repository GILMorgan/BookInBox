<?php

namespace App\Providers;

use App\Repository\BookRepository;
use App\Services\Books\BookSerializer;
use App\Domain\Books\DTO\Book;
use App\Domain\Books\Contract\BookProviderInterface;

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
}
