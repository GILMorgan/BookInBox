<?php

namespace tests\Providers;

use App\Entity\User;
use App\Providers\UserProvider;
use App\Repository\UserRepository;
use App\Services\Users\UserSerializer;
use tests\Domain\Users\UserFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
            ->setPassword("test")
            ->setDeleted(false)
		;

		$userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive("findAll")->andReturn(array_fill(0, 10, $user));
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);

		$userProvider = new UserProvider(
			$userRepository,
            new UserSerializer(),
            $userPasswordHasher,
		);
		$users = $userProvider->getAll();

		$this->assertCount(10, $users);
	}

	public function testGetByEmail()
	{
		$user = new User();
		$user
			->setId("1254-ffbf-45524-11578")
            ->setEmail("test@bookinbox.com")
            ->setPassword("test")
            ->setDeleted(false)
		;

		$userRepository = Mockery::mock(UserRepository::class);
		$userRepository->shouldReceive("findOnebyEmail")->andReturn($user);
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);

		$userProvider = new UserProvider(
			$userRepository,
			new UserSerializer(),
	        $userPasswordHasher,
	    );
		$users = $userProvider->getByEmail("test@bookinbox.com");

		$this->assertSame("test@bookinbox.com", $users->email);
	}

	public function testGetByEmailNotFound()
	{
		$userRepository = Mockery::mock(UserRepository::class);
		$userRepository->shouldReceive("findOnebyEmail")->andReturn($user);
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);

		$userProvider = new UserProvider(
            $userRepository,
			new UserSerializer(),
	        $userPasswordHasher,
	    );
		$users = $userProvider->getByEmail("test@bookinbox.com");

		$this->assertNull($users);
	}

	public function testAdd()
	{
		$user = UserFactory::getUser();	

		$userRepository = Mockery::mock(UserRepository::class);
		$userRepository->shouldReceive("save")->andReturnArg(0);
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordHasher->shouldReceive("hashPassword")->andReturn("hashedPassword");

		$userProvider = new UserProvider(
			$userRepository,
            new UserSerializer(),
            $userPasswordHasher,
		);
		$userSaved = $userProvider->add($user);

		$this->assertSame($userSaved, $user);
    }

    public function testDelete()
    {
        $user = UserFactory::getUser();	

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive("find")->andReturn(new User());
        $userRepository->shouldReceive("save")->andReturnArg(0);

        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);

		$userProvider = new UserProvider(
			$userRepository,
            new UserSerializer(),
            $userPasswordHasher,
		);
		$userDeleted = $userProvider->delete($user);

		$this->assertSame($userDeleted, $user);
    }
}
