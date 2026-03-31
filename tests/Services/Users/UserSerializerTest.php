<?php

namespace tests\Services\User;

use App\Entity\User as UserEntity;
use App\Services\Users\UserSerializer;
use PHPUnit\Framework\TestCase;

class UserSerializerTest extends TestCase
{
	public function testSerialize()
	{
		$userEntity = new UserEntity();
		$userEntity
			->setId("1254-4eaf-1548-ffff")
			->setEmail("test@bookingbox.local")
			->setRoles(["ROLE_ADMIN"])
		;

		$userSerializer = new UserSerializer();

		$dto = $userSerializer->toDto($userEntity);

		$this->assertSame("1254-4eaf-1548-ffff", $dto->id);
		$this->assertSame("test@bookingbox.local", $dto->email);
		$this->assertSame(["ADMIN", "USER"], $dto->roles);
	}
}
