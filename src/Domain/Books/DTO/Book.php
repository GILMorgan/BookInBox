<?php

namespace App\Domain\Books\DTO;

final class Book
{
    public string $id;
    public string $openlibraryId;
    public string $title;
    public array $authors;
    public string $publishDate;
    public string $publisher;
    public string $isbn10;
    public string $isbn13;
    public int $numberOfPages;
}
