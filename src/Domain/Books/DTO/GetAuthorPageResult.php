<?php

namespace App\Domain\Books\DTO;

final class GetAuthorPageResult
{
    public function __construct(
        public readonly array $authors,
        public readonly int $nbAuthors
    ) {
    }
}
