<?php

namespace tests\Services\Books;

use App\Services\Books\BookSerializer;
use App\Entity\Book;
use tests\Domain\Books\BookFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookSerializerTest extends TestCase
{
    public function testToEntity()
    {
        $book = BookFactory::getBook();

        $bookSerializer = new BookSerializer();

        $entity = $bookSerializer->toEntity($book);

        $this->assertSame("1245-afdc-457ef-5f7fff", $entity->getId());
        $this->assertSame("OL45804W", $entity->getOpenlibraryId());
        $this->assertSame("Le monde de Bob", $entity->getTitle());
        $this->assertSame(["Bob Enough"], $entity->getAuthors());
        $this->assertSame("25/12/1978", $entity->getPublishDate());
        $this->assertSame("Pingouin edition", $entity->getPublisher());
        $this->assertSame("0140328726", $entity->getIsbn10());
        $this->assertSame("9780140328721", $entity->getIsbn13());
        $this->assertSame(130, $entity->getNumberOfPages());
    }

    public function testToDto()
    {
        $entity = new Book();
        $entity
            ->setId("1245-afdc-457ef-5f7fff")
            ->setOpenlibraryId("OL45804W")
            ->setTitle("Le monde de Bob")
            ->setAuthors(["Bob Enough"])
            ->setPublishDate("25/12/1978")
            ->setPublisher("Pingouin edition")
            ->setIsbn10("0140328726")
            ->setIsbn13("9780140328721")
            ->setNumberOfPages(130)
        ;

        $bookSerializer = new BookSerializer();
        $dto = $bookSerializer->toDto($entity); 

        $this->assertSame("1245-afdc-457ef-5f7fff", $dto->id);
        $this->assertSame("OL45804W", $dto->openlibraryId);
        $this->assertSame("Le monde de Bob", $dto->title);
        $this->assertSame(["Bob Enough"], $dto->authors);
        $this->assertSame("25/12/1978", $dto->publishDate);
        $this->assertSame("Pingouin edition", $dto->publisher);
        $this->assertSame("0140328726", $dto->isbn10);
        $this->assertSame("9780140328721", $dto->isbn13);
        $this->assertSame(130, $dto->numberOfPages);
    }
}
