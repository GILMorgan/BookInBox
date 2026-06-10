<?php

namespace tests\Domain\Books\Controller;

use PHPUnit\Framework\TestCase;
use App\Domain\Books\DTO\Author;
use App\Domain\Books\Controller\AddNewAuthor;
use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\Controller\Exception\AuthorAllReadyExistException;
use App\Providers\Exception\AuthorNotFoundException;
use Mockery;

class AddNewAuthorTest extends TestCase
{
    public function testAllReadyExist()
    {
        $author = new Author();
        $author->goodreadId = "goodReadId";

        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("getByGoodreadId")->andReturn(new Author());

        $addNewAuthor = new AddNewAuthor($authorProvider);

        $this->expectException(AuthorAllReadyExistException::class);
        $author = $addNewAuthor->addNewAuthor($author);
    }

    public function testNewAuthor()
    {
        $author = new Author();
        $author->goodreadId = "goodReadId";

        $authorProvider = Mockery::mock(AuthorProviderInterface::class);
        $authorProvider->shouldReceive("getByGoodreadId")->andThrow(new AuthorNotFoundException());
        $authorProvider->shouldReceive("save")->andReturnArg(0);

        $addNewAuthor = new AddNewAuthor($authorProvider);

        $author = $addNewAuthor->addNewAuthor($author);
        $this->assertNotNull($author);
    }
}
