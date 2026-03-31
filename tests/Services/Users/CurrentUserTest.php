<?php

namespace tests\Services\User;

use App\Entity\User as UserEntity;
use App\Services\Users\UserSerializer;
use App\Services\Users\CurrentUser;
use Symfony\Bundle\SecurityBundle\Security;
use PHPUnit\Framework\TestCase;
use Mockery;

class CurrentUserTest extends TestCase
{
	public function testGetCurrentUser()	
	{
		$userEntity = new UserEntity();
		$userEntity
			->setId("1254-4eaf-1548-ffff")
			->setEmail("test@bookingbox.local")
			->setRoles(["ROLE_ADMIN"])
		;

		$security = Mockery::mock(Security::class);
		$security->shouldReceive("getUser")->andReturn($userEntity);

		$currentUser = new CurrentUser(
			$security,
			new UserSerializer()
		);
	
		$user = $currentUser->getUser();

		$this->assertSame("1254-4eaf-1548-ffff", $user->id);
	}	
}
