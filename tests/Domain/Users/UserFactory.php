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
        $user->password = "user";
        $user->isDeleted = false;

		return $user;
	}

	public static function getAdmin(): User
	{
		$user = new User();
		$user->id = "5472-4eaf-1548-ffff";
		$user->roles = ['USER', 'ADMIN'];
        $user->email = "admin@bookinbox.com";
        $user->password = "admin";
        $user->isDeleted = false;

		return $user;
	}
}
