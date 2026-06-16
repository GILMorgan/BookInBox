<?php

namespace App\Domain\Books\DTO;

final class SaveBookParams
{
    public function __construct(
        public readonly string $title,
        public readonly string $isbn13,
        public readonly string $isbn10,
        public readonly string $publisher,
        public readonly string $publishDate,
        public readonly int $numberOfPages,
        public readonly array $authors,
        public readonly string $serieName = '',
        public readonly float $serieNumber = 0
    ) {
    }
}
