<?php

namespace App\Services\Books;

use App\Entity\Book as BookEntity;
use App\Domain\Books\DTO\Book;

final class BookSerializer
{
    public function toEntity(Book $book): BookEntity
    {
        $entity = new BookEntity();
        $entity
            ->setId($book->id)
            ->setOpenlibraryId($book->openlibraryId)
            ->setTitle($book->title)
            ->setAuthors($book->authors)
            ->setPublishDate($book->publishDate)
            ->setPublisher($book->publisher)        
            ->setIsbn10($book->isbn10)
            ->setIsbn13($book->isbn13)
            ->setNumberOfPages($book->numberOfPages);

        return $entity;
    }
}
