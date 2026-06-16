<?php

namespace App\Domain\Books\DTO;

final class SearchAuthorResults
{
    public function __construct(public readonly array $authors)
    {
    }
}
