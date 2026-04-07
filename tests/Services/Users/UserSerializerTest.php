<?php

namespace tests\Services\User;

use App\Entity\User as UserEntity;
use App\Services\Users\UserSerializer;
use PHPUnit\Framework\TestCase;
use tests\Domain\Users\UserFactory;

class UserSerializerTest extends TestCase
{
	public function testToDto()
	{
		$userEntity = new UserEntity();
		$userEntity
			->setId("1254-4eaf-1548-ffff")
			->setEmail("test@bookingbox.local")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword("test")
            ->setDeleted(false)
		;

		$userSerializer = new UserSerializer();

		$dto = $userSerializer->toDto($userEntity);

		$this->assertSame("1254-4eaf-1548-ffff", $dto->id);
		$this->assertSame("test@bookingbox.local", $dto->email);
        $this->assertSame(["ADMIN", "USER"], $dto->roles);
        $this->assertSame("test", $dto->password);
        $this->assertFalse($dto->isDeleted);
	}

	public function testToEntity()
	{
		$dto = UserFactory::getUser();

		$userSerializer = new UserSerializer();

		$userEntity = $userSerializer->toEntity($dto);

		$this->assertSame("1254-4eaf-1548-ffff", $userEntity->getId());
		$this->assertSame("user@bookinbox.com", $userEntity->getEmail());
        $this->assertSame(["ROLE_USER"], $userEntity->getRoles());
        $this->assertSame("user", $userEntity->getPassword());
        $this->assertFalse($userEntity->isDeleted());
	}
}
