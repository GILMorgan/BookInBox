<?php

namespace tests\Domain\Users\Controller;

use App\Domain\Users\DTO\User;
use App\Domain\Users\Controller\ListController;
use App\Domain\Users\Contract\UserProviderInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class ListControllerTest extends TestCase
{
	public function testSimpleUser()
	{
		$user = new User();
		$user->roles = ['USER'];

		$userProvider = Mockery::mock(UserProviderInterface::class);

		$listController = new ListController($userProvider);
		$users = $listController->getAllUser($user);

		$this->assertCount(1, $users);
		$this->assertSame($user, current($users));
	}

	public function testAdminUser()
	{
		$user = new User();
		$user->roles = ['USER', 'ADMIN'];

		$userProvider = Mockery::mock(UserProviderInterface::class);
		$userProvider->shouldReceive("getAll")->andReturn(array_fill(0, 5, $user));

		$listController = new ListController($userProvider);
		$users = $listController->getAllUser($user);

		$this->assertCount(5, $users);
	}
}

