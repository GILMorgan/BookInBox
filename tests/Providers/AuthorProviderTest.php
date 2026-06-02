<?php

namespace tests\Providers;

use App\Repository\AuthorRepository;
use App\Services\Books\AuthorSerializer;
use App\Providers\AuthorProvider;
use tests\Domain\Books\AuthorFactory;
use tests\Entity\AuthorFactory as AuthorEntityFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class AuthorProviderTest extends TestCase
{
    public function testSave()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("save")->andReturnArg(0);

        $authorProvider = new AuthorProvider($authorRepository);
        $this->assertSame($dto, $authorProvider->save($dto));
    }

    public function testDelete()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("find")->andReturn(AuthorEntityFactory::getAuthor());
        $authorRepository->shouldReceive("delete");

        $authorProvider = new AuthorProvider($authorRepository);

        $this->assertNull($authorProvider->delete($dto));
    }

    public function testGetAll()
    {
        $dto = AuthorFactory::getAuthor();
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findAll")->andReturn([AuthorEntityFactory::getAuthor()]);

        $authorProvider = new AuthorProvider($authorRepository);
        $authors = $authorProvider->getAll();

        $this->assertSame($dto->id, $authors[0]->id);
    }

    public function testGetByGoodreadIdFound()
    {
        $dto = AuthorFactory::getAuthor();

        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findOneByGoodreadId")->andReturn(AuthorEntityFactory::getAuthor());

        $authorProvider = new AuthorProvider($authorRepository);

        $this->assertSame($dto->id, $authorProvider->getByGoodreadId("goodReadId")->id);
    }

    public function testGetByGoodreadIdNotFound()
    {
        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findOneByGoodreadId")->andReturnNull();

        $authorProvider = new AuthorProvider($authorRepository);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Couldn't find author with the goodread id goodReadId");
        $authorProvider->getByGoodreadId("goodReadId");
    }

    public function testFindByName()
    {
        $dto = AuthorFactory::getAuthor();

        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findByName")->andReturn([AuthorEntityFactory::getAuthor()]);

        $authorProvider = new AuthorProvider($authorRepository);

        $this->assertSame($dto->id, $authorProvider->findByName("le livre")[0]->id);
    }

    public function testGetPage()
    {
        $dto = AuthorFactory::getAuthor();

        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("findPagined")->andReturn([AuthorEntityFactory::getAuthor()]);

        $authorProvider = new AuthorProvider($authorRepository);

        $this->assertSame($dto->id, $authorProvider->getPage(1)[0]->id);
    }
}
