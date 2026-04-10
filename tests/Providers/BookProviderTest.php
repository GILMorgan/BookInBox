<?php

namespace tests\Providers;

use App\Providers\BookProvider;
use App\Repository\BookRepository;
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

        $bookProvider = new BookProvider(
            $bookRepository,
            new BookSerializer()
        );

        $this->assertSame($dto, $bookProvider->save($dto));
    }
}
