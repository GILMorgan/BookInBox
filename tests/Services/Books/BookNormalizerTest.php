<?php

namespace tests\Services\Books;

use App\Services\Books\BookNormalizer;
use PHPUnit\Framework\TestCase;
use tests\Domain\Books\BookFactory;

class BookNormalizerTest extends TestCase
{
    public function testToArray()
    {
        $book = BookFactory::getBook();

        $array = BookNormalizer::toArray($book);

        $this->assertSame("1245-afdc-457ef-5f7fff", $array['id']);
        $this->assertSame("OL45804W", $array['openlibraryId']);
        $this->assertSame("Le monde de Bob", $array['title']);
        $this->assertSame("The Bobyverse", $array['serieName']);
        $this->assertSame(1.0, $array['serieNumber']);
        $this->assertSame("1547-dfcc-45d78-fe733", $array['authors'][0]['id']);
        $this->assertSame("25/12/1978", $array['publishDate']);
        $this->assertSame("Pingouin edition", $array['publisher']);
        $this->assertSame("0140328726", $array['isbn10']);
        $this->assertSame("9780140328721", $array['isbn13']);
        $this->assertSame(130, $array['numberOfPages']);
    }
}

