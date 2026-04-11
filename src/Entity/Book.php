<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Book
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    
    #[ORM\Column]
    private string $openlibraryId;
    
    #[ORM\Column]
    private string $title;
    
    #[ORM\Column()]
    private array $authors;
    
    #[ORM\Column]
    private string $publishDate;
        
    #[ORM\Column]
    private string $publishers;
    
    #[ORM\Column]
    private string $isbn10;
    
    #[ORM\Column]
    private string $isbn13;
    
    #[ORM\Column]
    private int $numberOfPages;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    } 

    public function getOpenlibraryId(): string
    {
        return $this->openlibraryId;
    } 

    public function setOpenlibraryId(string $openlibraryId): static
    {
        $this->openlibraryId = $openlibraryId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): static
    {
        $this->authors = $authors;

        return $this;    
    }

    public function getPublishDate(): string
    {
        return $this->publishDate;
    }

    public function setPublishDate(string $publishDate): static
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getPublisher(): string
    {
        return $this->publishers;
    }

    public function setPublisher(string $publishers): static
    {
        $this->publishers = $publishers;

        return $this;
    }

    public function getIsbn10(): string
    {
        return $this->isbn10;    
    }

    public function setIsbn10(string $isbn10): static
    {
        $this->isbn10 = $isbn10;

        return $this;
    }

    public function getIsbn13(): string
    {
        return $this->isbn13;    
    }

    public function setIsbn13(string $isbn13): static
    {
        $this->isbn13 = $isbn13;

        return $this;
    }

    public function getNumberOfPages(): int
    {
        return $this->numberOfPages;
    }

    public function setNumberOfPages(int $numberOfPages): static
    {
        $this->numberOfPages = $numberOfPages;    

        return $this;
    }
}
