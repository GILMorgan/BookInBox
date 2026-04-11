<?php

namespace tests\Domain\Books;

use App\Domain\Books\DTO\Author;

class AuthorFactory
{
    public static function getAuthor(): Author
    {
        $author = new Author;
        $author->id = "1547-dfcc-45d78-fe733";
        $author->name = "Bob the writer";
        $author->birthDate = "25/12/1978";
        $author->goodreadId = "goodReadId";

        return $author;
    }
}

