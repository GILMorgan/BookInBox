<?php

namespace App\Domain\Books\DTO;

final class SaveBookResults
{
    public function __construct(
        public readonly string $id,
        public readonly string $status
    ) {
    }
}
