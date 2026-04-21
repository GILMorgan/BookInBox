<?php

namespace App\Services\Books\OpenLibrarySerializers;

use App\Domain\Books\DTO\Author;
use Symfony\Component\Uid\Uuid;

class AuthorSerializer
{
    public function fromJsonApi(string $json): Author
    {
        $data = json_decode($json);

        $author = new Author();
        $author->id = (string) Uuid::v4(); 
        $author->name = $data->name;
        $author->birthDate = $this->getBirthDate($data);
        $author->goodreadId = $this->getGoodreadId($data);

        return $author;
    }

    private function getBirthDate(\stdClass $data): string
    {
        if (isset($data->birth_date)) {
            return $data->birth_date;
        }

        return "";
    }

    private function getGoodreadId(\stdClass $data): string
    {
        if (isset($data->remote_ids) && isset($data->remote_ids->goodreads)) {
            return $data->remote_ids->goodreads;
        }

        return "";
    }
}
