<?php

namespace App\Services\Books;

use App\Domain\Books\DVO\Author;
use App\Services\Books\OpenLibrarySerializers\AuthorSerializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenLibraryApi
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly AuthorSerializer $authorSerializer
    ) {
    }

    public function getAuthor(string $id): Author
    {
        $response = $this->httpClient->request(
            'GET',
            'https://openlibrary.org/authors/' . $id . '.json'
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception("OpenLibrary doesn\'t answer");         
        }

        return $this->authorSerializer->fromJsonApi($response->getContent());
    }
}

