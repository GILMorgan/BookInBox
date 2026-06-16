<?php

namespace App\Domain\Books\Controller;

use App\Domain\Books\Contract\BookProviderInterface;
use App\Domain\Books\Contract\BookIdGeneratorInterface;
use App\Domain\Books\Contract\Exception\BookNotFoundException;
use App\Domain\Books\DTO\SaveBookParams;
use App\Domain\Books\DTO\SaveBookResults;
use App\Domain\Books\DVO\Book;
use App\Domain\Books\Controller\Exception\BookAllReadyExistException;

final class AddBook
{
    public function __construct(
        private readonly BookProviderInterface $provider,
        private readonly BookIdGeneratorInterface $bookIdGenerator
    ) {
    }

    public function addBook(SaveBookParams $params): SaveBookResults
    {
        $this->checkIfBookAllReadyExist($params);
        $dto = $this->createDTO($params);

        $this->provider->save($dto);

        return new SaveBookResults(
            $dto->id,
            "created"
        );
    }

    public function checkIfBookAllReadyExist(SaveBookParams $params): void
    {
        try {
            $this->provider->getByIsbn13($params->isbn13);
        } catch (BookNotFoundException $e) {
            return;
        }

        throw new BookAllReadyExistException();
    }

    public function createDTO($params): Book
    {
        $book = new Book();
        $book->id = $this->bookIdGenerator->getId();
        $book->authors = $params->authors;
        $book->title = $params->title;
        $book->publishDate = $params->publishDate;
        $book->publisher = $params->publisher;
        $book->isbn10 = $params->isbn10;
        $book->isbn13 = $params->isbn13;
        $book->numberOfPages = $params->numberOfPages;
        $book->serieName = $params->serieName; 
        $book->serieNumber = $params->serieNumber;

        $book->openlibraryId = "";

        return $book;
    }
}
