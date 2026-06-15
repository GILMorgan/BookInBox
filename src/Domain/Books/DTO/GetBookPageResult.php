<?php

namespace App\Domain\Books\DTO;

final class GetBookPageResult
{
    public function __construct(
        public array $books,
        public int $nbBooks
    ) {
    }
}
