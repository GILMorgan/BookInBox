<?php

namespace App\Domain\Books\DTO;

final class GetAuthorPageParams
{
    public function __construct(
        public readonly int $pageIndex
    ) {
    }
}
