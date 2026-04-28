<?php

namespace App\Domain\Books\Contract;

use App\Domain\Books\DTO\Book;

interface BookProviderInterface
{
    public function getAll(): array;
    public function save(Book $book): Book;
    public function getNbOfBooks(): int;
    public function getNbOfPages(): int;
    public function getPage(int $page): array;
}
