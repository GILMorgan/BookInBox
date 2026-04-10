<?php

namespace tests\Services\Books;

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
        $this->assertSame("Bob the writer", $entity->getName());
        $this->assertSame("25/12/1978", $entity->getBirthDate());
        $this->assertSame("goodReadId", $entity->getGoodreadId());
    }
}
