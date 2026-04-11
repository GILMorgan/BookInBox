<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Author
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    public string $birthDate;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public string $goodreadId;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGoodreadId(): string
    {
        return $this->goodreadId;
    }

    public function setGoodreadId(string $goodreadId): static
    {
        $this->goodreadId = $goodreadId;

        return $this;
    }
}
