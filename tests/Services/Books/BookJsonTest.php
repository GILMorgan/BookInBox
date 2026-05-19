<?php

namespace tests\Services\Books;

use App\Services\Books\BookJson;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookJsonTest extends TestCase
{
    public function testFullJson()
    {
        $rawJson = '{"title":"title", "serieName":"serie", "authors":"75e9de92-a646-4a9e-8533-5a89b2b3db6e, 47c1ea7b-63f3-49ed-a471-d47800db2b9b", "nbPages": 120}';

        $bookJson = new BookJson();

        $book = $bookJson->toDto($rawJson);

        $this->assertNotNull($book->id);
        $this->assertSame('title', $book->title);
        $this->assertSame('serie', $book->serieName);
        $this->assertCount(2, $book->authors);
        $this->assertSame(["75e9de92-a646-4a9e-8533-5a89b2b3db6e", "47c1ea7b-63f3-49ed-a471-d47800db2b9b"], $book->authors);
        $this->assertSame(120, $book->numberOfPages);
    }
}
