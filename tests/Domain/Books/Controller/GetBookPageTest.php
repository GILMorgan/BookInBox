<?php

namespace tests\Domain\Books\Controller;

use App\Domain\Books\Controller\GetBookPage;
use App\Domain\Books\DTO\GetBookPageParams;
use App\Domain\Books\Contract\BookProviderInterface;
use PHPUnit\Framework\TestCase;
use Mockery;
use tests\Domain\Books\BookFactory;

class GetBookPageTest extends TestCase
{
    public function testGetBookPage()
    {
        $bookProvider = Mockery::mock(BookProviderInterface::class);
        $bookProvider->shouldReceive("getPage")->andReturn([BookFactory::getBook(), BookFactory::getBook()]);
        $bookProvider->shouldReceive("getNbOfBooks")->andReturn(15);

        $params = new GetBookPageParams(1);

        $getBookPage = new GetBookPage($bookProvider);

        $result = $getBookPage->getBookPage($params);

        $this->assertCount(2, $result->books);
        $this->assertSame(15, $result->nbBooks);    
    }
}
