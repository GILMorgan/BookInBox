<?php

namespace tests\Providers;

use App\Providers\BookProvider;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Services\Books\BookSerializer;
use App\Domain\Books\Contract\Exception\BookNotFoundException;
use tests\Domain\Books\BookFactory;
use tests\Entity\BookFactory as EntityBookFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class BookProviderTest extends TestCase
{
    public function testSave()
    {
        $dto = BookFactory::getBook();

        $bookRepository = Mockery::mock(BookRepository::class);
        $bookRepository->shouldReceive("save")->andReturnArg(0);

        $authorRepository = Mockery::mock(AuthorRepository::class);
        $authorRepository->shouldReceive("find")->andReturn(null); 

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer($authorRepository)
        );

        $this->assertSame($dto, $bookProvider->save($dto));
    }

    public function testGetAll()
    {
        $entity = EntityBookFactory::getBook();

        $bookRepository = Mockery::mock(BookRepository::class);
        $bookRepository->shouldReceive("findAll")->andReturn([$entity]);

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer($authorRepository)
        );

        $this->assertCount(1, $bookProvider->getAll());
    }

    public function testGetByIsbn13NotFound()
    {
        $bookRepository = Mockery::mock(BookRepository::class);
        $bookRepository->shouldReceive("findOneByIsbn13")->andReturnNull();

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer($authorRepository)
        );

        $this->expectException(BookNotFoundException::class);
        $bookProvider->getByIsbn13("not a real isbn");
    }

    public function testGetByIsbn13()
    {
        $entity = EntityBookFactory::getBook();

        $bookRepository = Mockery::mock(BookRepository::class);
        $bookRepository->shouldReceive("findOneByIsbn13")->andReturn($entity);

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer($authorRepository)
        );

        $dto = $bookProvider->getByIsbn13("a real isbn");
        $this->assertSame($entity->getId(), $dto->id);
    }
}
