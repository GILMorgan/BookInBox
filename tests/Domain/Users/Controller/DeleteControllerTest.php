<?php

namespace tests\Domain\Users\Controller;

use App\Domain\Users\Contract\UserProviderInterface;
use App\Domain\Users\Controller\DeleteController;
use App\Domain\Users\Exception\NotAuthorizedException;
use App\Domain\Users\Exception\CurrentUserException;
use tests\Domain\Users\UserFactory;
use PHPUnit\Framework\TestCase;
use Mockery;

class DeleteControllerTest extends TestCase
{
    public function testNotAdmin()
    {
        $userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getUser();
		$deleteUser = UserFactory::getUser();

        $deleteController = new DeleteController($userProvider);

        $this->expectException(NotAuthorizedException::class);
		$deleteController->deleteUser($currentUser, $deleteUser);
    }

    public function testCurrentUser()
    {
        $userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getAdmin();

        $deleteController = new DeleteController($userProvider);

        $this->expectException(CurrentUserException::class);
		$deleteController->deleteUser($currentUser, $currentUser);

    }
    
    public function testAdmin()
	{	
		$userProvider = Mockery::mock(UserProviderInterface::class);

		$currentUser = UserFactory::getAdmin();
		$deleteUser = UserFactory::getUser();

		$userProvider->shouldReceive("delete")->andReturnArg(0);

		$deleteController = new DeleteController($userProvider);

		$this->assertTrue($deleteController->deleteUser($currentUser, $deleteUser));
	}
}
