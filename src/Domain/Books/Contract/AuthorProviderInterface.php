<?php

namespace App\Domain\Books\Contract;

use App\Domain\Books\DTO\Author;

interface AuthorProviderInterface
{
    public function save(Author $author): Author;
    public function delete(Author $author): void;
}
