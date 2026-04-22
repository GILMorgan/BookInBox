<?php

use App\Services\GoodReadParser;
use App\Domain\Books\Contract\AuthorProviderInterface;
use tests\Domain\Books\AuthorFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class GoodReadParserTest extends TestCase
{
    public function testGoodRead()
    {
        $author = AuthorFactory::getAuthor();

        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("getByGoodreadId")->andReturn($author);

        $parser = new GoodReadParser($authorProvider);

        $dto = $parser->parse(__DIR__ . "/LaMer.html");

        $this->assertSame("La Mer de la tranquillité", $dto->title);
        $this->assertSame("9782743660499", $dto->isbn13);
        $this->assertSame("274366049X", $dto->isbn10);
        $this->assertSame("Rivages", $dto->publisher);
        $this->assertSame("August 23, 2023", $dto->publishDate);
        $this->assertSame(304, $dto->numberOfPages);
        $this->assertSame([$author->id], $dto->authors);
    }

    public function testGoodRead2()
    {
        $author = AuthorFactory::getAuthor();

        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("getByGoodreadId")->andReturn($author);

        $parser = new GoodReadParser($authorProvider);

        $dto = $parser->parse(__DIR__ . "/LeRegne.html");

        $this->assertSame("Le 5e règne", $dto->title);
        $this->assertSame("", $dto->isbn13);
        $this->assertSame("B0DM4DJQ6L", $dto->isbn10);
        $this->assertSame("Pocket", $dto->publisher);
        $this->assertSame("June 8, 2006", $dto->publishDate);
        $this->assertSame(528, $dto->numberOfPages);
        $this->assertSame([$author->id], $dto->authors);
    }

}
