<?php

namespace App\Domain\Books\DTO;

final class SearchAuthorParams
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
