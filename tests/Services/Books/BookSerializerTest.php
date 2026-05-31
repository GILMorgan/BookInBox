<?php

namespace tests\Services\Books;

use App\Repository\AuthorRepository;
use App\Services\Books\BookSerializer;
use App\Entity\Author;
use tests\Entity\BookFactory as EntityBookFactory;
use tests\Domain\Books\BookFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookSerializerTest extends TestCase
{
    public function testToEntity()
    {
        $author = new Author();
        $book = BookFactory::getBook();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("find")->andReturn($author);

        $bookSerializer = new BookSerializer($authorRepository);

        $entity = $bookSerializer->toEntity($book);

        $this->assertSame("1245-afdc-457ef-5f7fff", $entity->getId());
        $this->assertSame("OL45804W", $entity->getOpenlibraryId());
        $this->assertSame("Le monde de Bob", $entity->getTitle());
        $this->assertSame([$author], $entity->getAuthors());
        $this->assertSame("25/12/1978", $entity->getPublishDate());
        $this->assertSame("Pingouin edition", $entity->getPublisher());
        $this->assertSame("0140328726", $entity->getIsbn10());
        $this->assertSame("9780140328721", $entity->getIsbn13());
        $this->assertSame(130, $entity->getNumberOfPages());
    }

    public function testToDto()
    {
        $book = EntityBookFactory::getBook();

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookSerializer = new BookSerializer($authorRepository);
        $dto = $bookSerializer->toDto($book); 

        $this->assertSame("1245-afdc-457ef-5f7fff", $dto->id);
        $this->assertSame("OL45804W", $dto->openlibraryId);
        $this->assertSame("Le monde de Bob", $dto->title);
        $this->assertSame("Bobyverse 1", $dto->serieName);
        $this->assertSame(1.0, $dto->serieNumber);
        $this->assertSame("1547-dfcc-45d78-fe733", $dto->authors[0]->id);
        $this->assertSame("25/12/1978", $dto->publishDate);
        $this->assertSame("Pingouin edition", $dto->publisher);
        $this->assertSame("0140328726", $dto->isbn10);
        $this->assertSame("9780140328721", $dto->isbn13);
        $this->assertSame(130, $dto->numberOfPages);
    }

    public function testToArray()
    {
        $book = BookFactory::getBook();

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookSerializer = new BookSerializer($authorRepository);

        $array = $bookSerializer->toArray($book);

        $this->assertSame("1245-afdc-457ef-5f7fff", $array['id']);
        $this->assertSame("OL45804W", $array['openlibraryId']);
        $this->assertSame("Le monde de Bob", $array['title']);
        $this->assertSame('1547-dfcc-45d78-fe733', $array['authors'][0]['id']);
        $this->assertSame("25/12/1978", $array['publishDate']);
        $this->assertSame("Pingouin edition", $array['publisher']);
        $this->assertSame("0140328726", $array['isbn10']);
        $this->assertSame("9780140328721", $array['isbn13']);
        $this->assertSame(130, $array['numberOfPages']);
    }
}
