<?php

use App\Services\GoodReadParser;
use PHPUnit\Framework\TestCase;

class GoodReadParserTest extends TestCase
{
    public function testGoodRead()
    {
        $parser = new GoodReadParser();

        $dto = $parser->parse(__DIR__ . "/LaMer.html");

        $this->assertSame("La Mer de la tranquillité", $dto->title);
        $this->assertSame("9782743660499", $dto->isbn13);
        $this->assertSame("274366049X", $dto->isbn10);
        $this->assertSame("Rivages", $dto->publisher);
        $this->assertSame("August 23, 2023", $dto->publishDate);
        $this->assertSame(304, $dto->numberOfPages);
    }
}
