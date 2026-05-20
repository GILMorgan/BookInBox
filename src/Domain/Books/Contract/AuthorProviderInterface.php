<?php

namespace App\Domain\Books\Contract;

use App\Domain\Books\DTO\Author;

interface AuthorProviderInterface
{
    public function save(Author $author): Author;
    public function delete(Author $author): void;
    public function get(string $id): Author;
    public function getAll(): array;
    public function getByGoodreadId(string $goodreadId): Author;
    public function getNbOfAuthors() :int;
    public function getPage(int $page): array;
    public function findByName(string $name): array;
}
