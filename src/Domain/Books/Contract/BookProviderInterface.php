<?php

namespace App\Domain\Books\Contract;

use App\Domain\Books\DTO\Book;

interface BookProviderInterface
{
    public function save(Book $book): Book;
}
