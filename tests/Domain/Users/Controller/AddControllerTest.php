<?php

namespace tests\Domain\Users\Controller;

use App\Domain\Users\Contract\UserProviderInterface;
use App\Domain\Users\Controller\AddController;
use App\Domain\Users\Exception\AllReadyExistException;
use App\Domain\Users\Exception\NotAuthorizedException;
use tests\Domain\Users\UserFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class AddControllerTest extends TestCase
{
	public function testNotAdmin()
	{
		$userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getUser();
		$newUser = UserFactory::getUser();

		$addController = new AddController($userProvider);

		$this->expectException(NotAuthorizedException::class);
		$addController->addUser($currentUser, $newUser);
	}

	public function testUserAllReadyExist()
	{	
		$userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getAdmin();
		$newUser = UserFactory::getUser();

		$userProvider->shouldReceive("getByEmail")->andReturn($newUser);

		$addController = new AddController($userProvider);

		$this->expectException(AllReadyExistException::class);
		$addController->addUser($currentUser, $newUser);
	}

	public function testAdmin()
	{	
		$userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getAdmin();
		$newUser = UserFactory::getUser();

		$userProvider->shouldReceive("getByEmail")->andReturnNull();
		$userProvider->shouldReceive("save")->andReturnArg(0);

		$addController = new AddController($userProvider);

		$this->assertTrue($addController->addUser($currentUser, $newUser));
	}
}
