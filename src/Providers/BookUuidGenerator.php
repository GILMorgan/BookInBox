<?php

namespace App\Providers;

use App\Domain\Books\Contract\BookIdGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class BookUuidGenerator implements BookIdGeneratorInterface
{
    public function getId(): string
    {
        return (string) Uuid::v4();
    }
}
