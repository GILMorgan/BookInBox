<?php

namespace tests\Providers;

use App\Entity\Book;
use App\Providers\BookProvider;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Services\Books\BookSerializer;
use tests\Domain\Books\BookFactory;
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
        $dto = BookFactory::getBook();
        $entity = new Book();
        $entity
            ->setId("1245-afdc-457ef-5f7fff")
            ->setOpenLibraryId("OL45804W")
            ->setTitle("title")
            ->setSerieName("")
            ->setSerieNumber(0)
            ->setAuthors(["authorId"])
            ->setPublishDate("25/12/1978")
            ->setPublisher("Pingouin editions")
            ->setIsbn10("isbn10")
            ->setIsbn13("isbn13")
            ->setNumberOfPages(150)
        ;

        $bookRepository = Mockery::mock(BookRepository::class);
        $bookRepository->shouldReceive("findAll")->andReturn([$entity]);

        $authorRepository = Mockery::mock(AuthorRepository::class);

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer($authorRepository)
        );

        $this->assertCount(1, $bookProvider->getAll());
    }
}
