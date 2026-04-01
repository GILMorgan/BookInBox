<?php

namespace App\Providers;

use App\Domain\Users\Contract\UserProviderInterface;
use App\Repository\UserRepository;
use App\Services\Users\UserSerializer;

final class UserProvider implements UserProviderInterface
{
	public function __construct(
		private readonly UserRepository $userRepository,
		private readonly UserSerializer $userSerializer
	) {
	}

	public function getAll(): array
	{
		return array_map(
			function ($user) {
				return $this->userSerializer->toDto($user);
			},
			$this->userRepository->findAll(),
		);
	}
}
