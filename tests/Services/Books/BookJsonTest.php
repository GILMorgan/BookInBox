<?php

namespace tests\Services\Books;

use App\Services\Books\BookJson;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookJsonTest extends TestCase
{
    public function testFullJson()
    {
        $rawJson = '{"title":"title", "serieName":"serie", "serieNumber":"1.5", "publishDate": "12 september 1981", "publisher": "Pingouin Ed", "isbn10": "1542-457", "isbn13": "1545-BE-55555", "authors":"75e9de92-a646-4a9e-8533-5a89b2b3db6e, 47c1ea7b-63f3-49ed-a471-d47800db2b9b", "nbPages": 120}';

        $request = Mockery::mock(Request::class);
        $request->shouldReceive("getContent")->andReturn($rawJson);

        $bookJson = new BookJson();

        $book = $bookJson->toDto($request);

        $this->assertSame('title', $book->title);
        $this->assertSame('serie', $book->serieName);
        $this->assertSame(1.5, $book->serieNumber);
        $this->assertSame("12 september 1981", $book->publishDate);
        $this->assertSame("Pingouin Ed", $book->publisher);
        $this->assertSame("1542-457", $book->isbn10);
        $this->assertSame("1545-BE-55555", $book->isbn13);
        $this->assertCount(2, $book->authors);
        $this->assertSame(["75e9de92-a646-4a9e-8533-5a89b2b3db6e", "47c1ea7b-63f3-49ed-a471-d47800db2b9b"], $book->authors);
        $this->assertSame(120, $book->numberOfPages);
    }
}
