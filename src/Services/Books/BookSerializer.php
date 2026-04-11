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

    public function toDto(BookEntity $bookEntity): Book
    {
        $dto = new Book();
        $dto->id = $bookEntity->getId();
        $dto->openlibraryId = $bookEntity->getOpenlibraryId();
        $dto->title = $bookEntity->getTitle();
        $dto->authors = $bookEntity->getAuthors();
        $dto->publishDate = $bookEntity->getPublishDate();
        $dto->publisher = $bookEntity->getPublisher();
        $dto->isbn10 = $bookEntity->getIsbn10();
        $dto->isbn13 = $bookEntity->getIsbn13();
        $dto->numberOfPages = $bookEntity->getNumberOfPages();

        return $dto;
    }
}
