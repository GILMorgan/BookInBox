<?php

namespace tests\Domain\Books;

use App\Domain\Books\DTO\Book;
use tests\Domain\Books\AuthorFactory;

class BookFactory
{
    public static function getBook(): Book
    {
        $book = new Book();
        $book->id = "1245-afdc-457ef-5f7fff";
        $book->openlibraryId = "OL45804W";
        $book->title = "Le monde de Bob";
        $book->serieName = "The Bobyverse";
        $book->serieNumber = 1;
        $book->authors = [AuthorFactory::getAuthor()];
        $book->publishDate = "25/12/1978";
        $book->publisher = "Pingouin edition";
        $book->isbn10 = "0140328726";
        $book->isbn13 = "9780140328721";
        $book->numberOfPages = 130;    

        return $book;
    }
}
