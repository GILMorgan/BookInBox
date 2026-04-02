<?php

namespace App\Domain\Users\Contract;

use App\Domain\Users\DTO\User;

interface UserProviderInterface
{
	public function getAll(): array;
	public function getByEmail(string $email): ?User;
	public function save(User $user): User;
}
