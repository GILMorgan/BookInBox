<?php

namespace tests\Providers;

use App\Providers\BookUuidGenerator;
use PHPUnit\Framework\TestCase;

class BookUuidGeneratorTest extends TestCase
{
    public function testGetId()
    {
        $bookUuidGenerator = new BookUuidGenerator();

        $this->assertNotNull($bookUuidGenerator->getId());
    }
}
