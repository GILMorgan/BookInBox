<?php

namespace tests\Services\Books;

use App\Entity\Author;
use App\Services\Books\AuthorSerializer;
use PHPUnit\Framework\TestCase;
use tests\Domain\Books\AuthorFactory;

class AuthorSerializerTest extends TestCase
{
    public function testToEntity()
    {
        $dto = AuthorFactory::getAuthor();

        $authorSerializer = new AuthorSerializer();
        $entity = $authorSerializer->toEntity($dto);

        $this->assertSame("1547-dfcc-45d78-fe733", $entity->getId());
        $this->assertSame("The writer", $entity->getName());
        $this->assertSame("Bob", $entity->getFirstName());
        $this->assertSame("25/12/1978", $entity->getBirthDate());
        $this->assertSame("goodReadId", $entity->getGoodreadId());
    }

    public function testToDTO()
    {
        $entity = new Author();
        $entity
            ->setId("1547-dfcc-45d78-fe733")
            ->setName("The writer")
            ->setFirstName("Bob")
            ->setBirthDate("25/12/1978")
            ->setGoodreadId("goodReadId")
        ;

        $authorSerializer = new AuthorSerializer();
        $dto = $authorSerializer->toDto($entity);

        $this->assertSame("1547-dfcc-45d78-fe733", $dto->id);
        $this->assertSame("The writer", $dto->name);
        $this->assertSame("Bob", $dto->firstName);
        $this->assertSame("25/12/1978", $dto->birthDate);
        $this->assertSame("goodReadId", $dto->goodreadId);
    }
}
