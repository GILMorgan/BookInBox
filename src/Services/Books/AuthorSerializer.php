<?php

namespace App\Services\Books;

use App\Domain\Books\DTO\Author;
use App\Entity\Author as Entity;

class AuthorSerializer
{
    public function toEntity(Author $author): Entity
    {
        $entity = new Entity();
        $entity
            ->setId($author->id)
            ->setName($author->name)
            ->setBirthDate($author->birthDate)
            ->setGoodreadId($author->goodreadId)
        ;

        return $entity;
    }
}
