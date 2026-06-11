<?php

namespace App\Domain\Books\DVO;

final class Book
{
    public string $id;
    public string $openlibraryId;
    public string $title;
    public string $serieName;
    public float $serieNumber;
    public array $authors;
    public string $publishDate;
    public string $publisher;
    public string $isbn10;
    public string $isbn13;
    public int $numberOfPages;
}
