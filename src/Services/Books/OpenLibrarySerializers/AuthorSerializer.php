<?php

namespace App\Services\Books\OpenLibrarySerializers;

use App\Domain\Books\DTO\Author;

class AuthorSerializer
{
    public function fromJsonApi(string $json): Author
    {
        $data = json_decode($json);

        $author = new Author();
        $author->name = $data->name;
        $author->birthDate = $data->birth_date;
        $author->goodreadId = $data->remote_ids->goodreads;

        return $author;
    }
}
