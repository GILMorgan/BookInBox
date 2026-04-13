<?php

namespace tests\Providers;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Services\Books\AuthorSerializer;
use App\Providers\AuthorProvider;
use tests\Domain\Books\AuthorFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class AuthorProviderTest extends TestCase
{
    public function testSave()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("save")->andReturnArg(0);

        $authorSerializer = Mockery::mock(AuthorSerializer::class);
        $authorSerializer->shouldReceive("toEntity")->andReturn(new Author());

        $authorProvider = new AuthorProvider(
            $authorRepository,
            $authorSerializer
        );
        $this->assertSame($dto, $authorProvider->save($dto));
    }

    public function testDelete()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("find")->andReturn(new Author());
        $authorRepository->shouldReceive("delete");

        $authorSerializer = Mockery::mock(AuthorSerializer::class);

        $authorProvider = new AuthorProvider(
            $authorRepository,
            $authorSerializer
        );

        $this->assertNull($authorProvider->delete($dto));
    }

    public function testGetAll()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findAll")->andReturn([new Author()]);

        $authorSerializer = Mockery::mock(AuthorSerializer::class);
        $authorSerializer->shouldReceive("toDto")->andReturn($dto);

        $authorProvider = new AuthorProvider(
            $authorRepository,
            $authorSerializer
        );

        $this->assertSame([$dto], $authorProvider->getAll());
    }

    public function testGetByGoodreadIdFound()
    {
        $dto = AuthorFactory::getAuthor();

        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findOneByGoodreadId")->andReturn(new Author());

        $authorSerializer = Mockery::mock(AuthorSerializer::class);
        $authorSerializer->shouldReceive("toDto")->andReturn($dto);       

        $authorProvider = new AuthorProvider(
            $authorRepository,
            $authorSerializer
        );

        $this->assertSame($dto, $authorProvider->getByGoodreadId("goodReadId"));
    }

    public function testGetByGoodreadIdNotFound()
    {
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findOneByGoodreadId")->andReturnNull();

        $authorSerializer = Mockery::mock(AuthorSerializer::class);

        $authorProvider = new AuthorProvider(
            $authorRepository,
            $authorSerializer
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Couldn't find author with the goodread id goodReadId");
        $authorProvider->getByGoodreadId("goodReadId");
    }
}
