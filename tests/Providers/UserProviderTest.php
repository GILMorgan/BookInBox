<?php

namespace tests\Providers;

use App\Entity\User;
use App\Providers\UserProvider;
use App\Repository\UserRepository;
use App\Services\Users\UserSerializer;
use PHPUnit\Framework\TestCase;
use Mockery;

class UserProviderTest extends TestCase
{
	public function testGetAll()
	{
		$user = new User();
		$user
			->setId("1254-ffbf-45524-11578")
			->setEmail("test@bookinbox.com")
		;

		$userRepository = Mockery::mock(UserRepository::class);
		$userRepository->shouldReceive("findAll")->andReturn(array_fill(0, 10, $user));

		$userProvider = new UserProvider(
			$userRepository,
			new UserSerializer()
		);
		$users = $userProvider->getAll();

		$this->assertCount(10, $users);
	}
}
