<?php

namespace App\Domain\Users\Contract;

interface UserProviderInterface
{
	public function getAll(): array;
}
