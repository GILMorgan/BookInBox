<?php

namespace tests\Services\Books;

use App\Services\Books\OpenLibraryApi;
use App\Services\Books\OpenLibrarySerializers\AuthorSerializer;
use App\Domain\Books\DVO\Author;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class OpenLibraryApiTest extends TestCase
{
    public function testWrongResponse()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive("getStatusCode")->andReturn(404);

        $httpClient = Mockery::mock(HttpClientInterface::class);
        $httpClient->shouldReceive("request")->andReturn($response);

        $authorSerializer = Mockery::mock(AuthorSerializer::class);

        $openLibraryApi = new OpenLibraryApi(
            $httpClient,
            $authorSerializer
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("OpenLibrary doesn\'t answer");
        $openLibraryApi->getAuthor("testId");        
    }

    public function testRightResponse()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive("getStatusCode")->andReturn(200);
        $response->shouldReceive("getContent")->andReturn("json");

        $httpClient = Mockery::mock(HttpClientInterface::class);
        $httpClient->shouldReceive("request")->andReturn($response);

        $dto = new Author();
        $authorSerializer = Mockery::mock(AuthorSerializer::class);
        $authorSerializer->shouldReceive("fromJsonApi")->with("json")->andReturn($dto);

        $openLibraryApi = new OpenLibraryApi(
            $httpClient,
            $authorSerializer
        );

        $this->assertSame($dto, $openLibraryApi->getAuthor("testId"));
    }
}

