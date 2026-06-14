<?php

namespace tests\Domain\Books\Controller;

use PHPUnit\Framework\TestCase;
use App\Domain\Books\Controller\AddBook;
use App\Domain\Books\Contract\BookProviderInterface;
use App\Domain\Books\Contract\BookIdGeneratorInterface;
use App\Domain\Books\Contract\Exception\BookNotFoundException;
use App\Domain\Books\DTO\SaveBookParams;
use App\Domain\Books\Controller\Exception\BookAllReadyExistException;
use Mockery;
use tests\Domain\Books\BookFactory;

class AddBookTest extends TestCase
{
    public function testAddBookAllReadyExist()
    {
        $bookProvider = Mockery::mock(BookProviderInterface::class);     
        $bookProvider->shouldReceive("getByIsbn13")->andReturn(BookFactory::getBook());                                      

        $bookIdGenerator = Mockery::mock(BookIdGeneratorInterface::class);
        
        $saveBookParams = new SaveBookParams(
            "title",
            "isbn13",
            "isbn10",
            "publisher",
            "publishDate",
            172,
            []
        );

        $addBook = new AddBook($bookProvider, $bookIdGenerator);

        $this->expectException(BookAllReadyExistException::class);
        $addBook->addBook($saveBookParams);    
    }

    public function testAddBook()
    {
        $bookProvider = Mockery::mock(BookProviderInterface::class);     
        $bookProvider->shouldReceive("getByIsbn13")->andThrow(new BookNotFoundException());
        $bookProvider->shouldReceive("save")->andReturnArg(0);

        $bookIdGenerator = Mockery::mock(BookIdGeneratorInterface::class);
        $bookIdGenerator->shouldReceive("getId")->andReturn("newUUID");
        
        $saveBookParams = new SaveBookParams(
            "title",
            "isbn13",
            "isbn10",
            "publisher",
            "publishDate",
            172,
            []
        );

        $addBook = new AddBook($bookProvider, $bookIdGenerator);
        $result = $addBook->addBook($saveBookParams);    

        $this->assertSame("newUUID", $result->id);
        $this->assertSame("created", $result->status);
    }
}
