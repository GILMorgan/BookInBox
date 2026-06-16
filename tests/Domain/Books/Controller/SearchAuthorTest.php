<?php

namespace tests\Domain\Books\Controller;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\DTO\SearchAuthorParams;
use App\Domain\Books\Controller\SearchAuthor;
use tests\Domain\Books\AuthorFactory;

class SearchAuthorTest extends TestCase
{
    public function testSearchAuthor()
    {
        $searchAuthorParams = new SearchAuthorParams("The writer");

        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("findByName")->andReturn([AuthorFactory::getAuthor()]);

        $searchAuthor = new SearchAuthor($authorProvider);
        $result = $searchAuthor->searchAuthor($searchAuthorParams);

        $this->assertSame("The writer", $result->authors[0]->name);
    }
}
