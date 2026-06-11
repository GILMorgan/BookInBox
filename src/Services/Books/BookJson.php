<?php

namespace App\Services\Books;

use App\Domain\Books\DVO\Book;
use Symfony\Component\Uid\Uuid;

final class BookJson
{
    public function toDto(string $jsonString): Book
    {
        $json = json_decode($jsonString);

        $book = new Book();
        $book->id = (string) Uuid::v4();
        $book->title = $json->title;
        $book->openlibraryId = "";
        $book->serieName = $json->serieName;
        $book->serieNumber = (float) $json->serieNumber;
        $book->publishDate = $json->publishDate;
        $book->publisher = $json->publisher;
        $book->isbn10 = $json->isbn10;
        $book->isbn13 = $json->isbn13;
        $book->authors = explode(", ", $json->authors);
        $book->numberOfPages = $json->nbPages;

        return $book;
    }
}
