<?php

namespace tests\Services\Books;

use App\Services\Books\BookSerializer;
use tests\Domain\Books\BookFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookSerializerTest extends TestCase
{
    public function testToDto()
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
}
