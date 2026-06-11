<?php

namespace App\Services\Books;

use App\Domain\Books\DVO\Author;

final class AuthorNormalizer
{
    public static function toArray(Author $author): array
    {
        return [
            "id" => $author->id,
            "birthDate" => $author->birthDate,
            "firstName" => $author->firstName,
            "goodreadId" => $author->goodreadId,
            "name" => $author->name
        ];
    }
}
