<?php

namespace App\Services\Books;

use App\Entity\Book as BookEntity;
use App\Domain\Books\DTO\Book;
use App\Repository\AuthorRepository;
use App\Services\Books\AuthorSerializer;
use App\Services\Books\BookSerializer;

final class BookSerializer
{
    public function __construct(private readonly AuthorRepository $authorRepository)
    {
    }

    public function toEntity(Book $book): BookEntity
    {
        $authors = array_map(
            function ($author) {
                return $this->authorRepository->find($author);
            },
            $book->authors
        );

        $entity = new BookEntity();
        $entity
            ->setId($book->id)
            ->setOpenlibraryId($book->openlibraryId)
            ->setTitle($book->title)
            ->setSerieName($book->serieName)
            ->setSerieNumber($book->serieNumber)
            ->setAuthors($authors)
            ->setPublishDate($book->publishDate)
            ->setPublisher($book->publisher)        
            ->setIsbn10($book->isbn10)
            ->setIsbn13($book->isbn13)
            ->setNumberOfPages($book->numberOfPages);

        return $entity;
    }

    public function toDto(BookEntity $bookEntity): Book
    {
        $authorSerializer = new AuthorSerializer();

        $dto = new Book();
        $dto->id = $bookEntity->getId();
        $dto->openlibraryId = $bookEntity->getOpenlibraryId();
        $dto->title = $bookEntity->getTitle();
        $dto->serieName = $bookEntity->getSerieName();
        $dto->serieNumber = $bookEntity->getSerieNumber();
        $dto->authors = array_map(
            function ($author) use ($authorSerializer) {
                return $authorSerializer->toDto($author);
            },
            $bookEntity->getAuthors()
        );
        $dto->publishDate = $bookEntity->getPublishDate();
        $dto->publisher = $bookEntity->getPublisher();
        $dto->isbn10 = $bookEntity->getIsbn10();
        $dto->isbn13 = $bookEntity->getIsbn13();
        $dto->numberOfPages = $bookEntity->getNumberOfPages();

        return $dto;
    }
}
