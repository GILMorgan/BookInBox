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
            ->setFirstName($author->firstName)
            ->setBirthDate($author->birthDate)
            ->setGoodreadId($author->goodreadId);

        return $entity;
    }

    public function toDto(Entity $entity): Author
    {
        $author = new Author();
        $author->id = $entity->getId();
        $author->birthDate = $entity->getBirthDate();
        $author->firstName = $entity->getFirstName();
        $author->goodreadId = $entity->getGoodreadId();
        $author->name = $entity->getName();

        return $author;
    }

    public function toArray(Author $author): array
    {
        return [
            "id" => $author->id,
            "birthDate" => $author->birthDate,
            "firstName" => $author->firstName,
            "goodreadId" => $author->goodreadId,
            "name" => $author->name
        ];
    }
}
