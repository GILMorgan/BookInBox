<?php

namespace App\Services\Books;

use App\Domain\Books\DTO\Book;

final class BookNormalizer
{
    public static function toArray(Book $book): array
    {
        return [
            'id' => $book->id,
            'openlibraryId' => $book->openlibraryId,
            'title' => $book->title,
            'serieName' => $book->serieName,
            'serieNumber' => $book->serieNumber,
            'authors' => array_map(
                function ($author) {
                    return AuthorNormalizer::toArray($author);
                },
                $book->authors
            ),
            'publishDate' => $book->publishDate,
            'publisher' => $book->publisher,
            'isbn10' => $book->isbn10,
            'isbn13' => $book->isbn13,
            'numberOfPages' => $book->numberOfPages,
        ];
    }
}
