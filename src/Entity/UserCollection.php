<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USER_BOOK', fields: ['userId', 'bookId'])]
class UserCollection
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private string $userId;

    #[ORM\Column]
    private string $bookId;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setUserId(string $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function setBookId(string $bookId): static
    {
        $this->bookId = $bookId;

        return $this;
    }
}
