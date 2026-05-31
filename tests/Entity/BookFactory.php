<?php

namespace tests\Entity;

use App\Entity\Book;
use tests\Entity\AuthorFactory;

class BookFactory
{
    public static function getBook(): Book
    {
        return (new Book())
            ->setId('1245-afdc-457ef-5f7fff')
            ->setOpenlibraryId("OL45804W")
            ->setTitle("Le monde de Bob")
            ->setSerieName("Bobyverse 1")
            ->setSerieNumber(1)
            ->setAuthors([AuthorFactory::getAuthor()])
            ->setPublishDate("25/12/1978")
            ->setPublisher("Pingouin edition")
            ->setIsbn10("0140328726")
            ->setIsbn13("9780140328721")
            ->setNumberOfPages(130)
        ;
    }    
}
