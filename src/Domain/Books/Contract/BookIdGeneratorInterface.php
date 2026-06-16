<?php

namespace App\Domain\Books\Contract;

interface BookIdGeneratorInterface
{
    public function getId(): string;
}
