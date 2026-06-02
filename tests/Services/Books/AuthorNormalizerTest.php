<?php

namespace tests\Services\Books;

use App\Services\Books\AuthorNormalizer;
use PHPUnit\Framework\TestCase;
use tests\Domain\Books\AuthorFactory;

class AuthorNormalizerTest extends TestCase
{
    public function testToArray()
    {
        $array = AuthorNormalizer::toArray(AuthorFactory::getAuthor());

        $this->assertSame("1547-dfcc-45d78-fe733", $array['id']);
        $this->assertSame("25/12/1978", $array['birthDate']);
        $this->assertSame("Bob", $array['firstName']);
        $this->assertSame("The writer", $array['name']);
        $this->assertSame("goodReadId", $array['goodreadId']);
    }
}
