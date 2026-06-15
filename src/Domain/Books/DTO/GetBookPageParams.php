<?php

namespace App\Domain\Books\DTO;

final class GetBookPageParams
{
    public function __construct(
        public readonly int $pageIndex
    ) {
    }
}
