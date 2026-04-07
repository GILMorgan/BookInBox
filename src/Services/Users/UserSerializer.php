<?php

namespace App\Services\Users;

use App\Entity\User as UserEntity;
use App\Domain\Users\DTO\User as UserDto;

final class UserSerializer
{
    public function toDto(UserEntity $entity): UserDto 
    {
        $dto = new UserDto();
        $dto->id = $entity->getId();
        $dto->email = $entity->getEmail();
        $dto->roles = array_map(
            [$this, "formatRole"],
            $entity->getRoles()
        );
        $dto->password = $entity->getPassword();
        $dto->isDeleted = $entity->isDeleted();

        return $dto;
    }

    public function toEntity(UserDto $dto): UserEntity
    {
        $entity = new UserEntity();
        $entity
            ->setId($dto->id)
            ->setEmail($dto->email)
            ->setRoles(
                array_map(
                    [$this, "unformatRole"],
                    $dto->roles
                )
            )
            ->setPassword($dto->password)
            ->setDeleted($dto->isDeleted);

        return $entity;
    }

    private function formatRole(string $role): string
    {
        return preg_replace("/ROLE_/", "", $role);
    }

    private function unformatRole(string $role): string
    {
        return "ROLE_" . $role;
    }
}

