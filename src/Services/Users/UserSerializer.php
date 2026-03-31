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

		return $dto;
	}

	private function formatRole(string $role): string
	{
		return preg_replace("/ROLE_/", "", $role);
	}
}

