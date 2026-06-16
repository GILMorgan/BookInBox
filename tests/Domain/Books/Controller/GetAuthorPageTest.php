<?php

namespace tests\Domain\Books\Controller;

use PHPUnit\Framework\TestCase;
use App\Domain\Books\Controller\GetAuthorPage;
use App\Domain\Books\DTO\GetAuthorPageParams;
use App\Domain\Books\Contract\AuthorProviderInterface;
use Mockery;
use tests\Domain\Books\AuthorFactory;

class GetAuthorPageTest extends TestCase
{
    public function testGetAuthorPage()
    {
        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("getPage")->andReturn([
            AuthorFactory::getAuthor(),
            AuthorFactory::getAuthor(),
        ]);
        $authorProvider->shouldReceive("getNbOfAuthors")->andReturn(15);

        $getAuthorPageParams = new GetAuthorPageParams(1);
        $getAuthorPage = new GetAuthorPage($authorProvider);

        $result = $getAuthorPage->getAuthorPage($getAuthorPageParams);

        $this->assertCount(2, $result->authors);
        $this->assertSame(15, $result->nbAuthors);    
    }
}
