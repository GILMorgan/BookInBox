<?php

namespace tests\Entity;

use App\Entity\Author;

class AuthorFactory
{
    public static function getAuthor()
    {
        return (new Author)
            ->setId("1547-dfcc-45d78-fe733")
            ->setBirthDate("25/12/1978")
            ->setGoodreadId("goodReadId")
            ->setName("The writer")
            ->setFirstName("Bob")
        ;
    }
}
