<?php

namespace tests\Domain\Users;

use App\Domain\Users\DTO\User;

class UserFactory
{
	public static function getUser(): User
	{
		$user = new User();
		$user->id = "1254-4eaf-1548-ffff";
		$user->roles = ['USER'];
		$user->email = "user@bookinbox.com";

		return $user;
	}

	public static function getAdmin(): User
	{
		$user = new User();
		$user->id = "5472-4eaf-1548-ffff";
		$user->roles = ['USER', 'ADMIN'];
		$user->email = "admin@bookinbox.com";

		return $user;
	}
}
