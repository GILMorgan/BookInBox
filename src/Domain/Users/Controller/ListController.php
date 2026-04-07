<?php

namespace App\Domain\Users\Controller;

use App\Domain\Users\DTO\User;
use App\Domain\Users\Contract\UserProviderInterface;

final class ListController
{
    public function __construct(private readonly UserProviderInterface $userProvider)
    {
    }

    public function getAllUsers(User $user): array
    {
        if (in_array("ADMIN", $user->roles)) {
            return $this->userProvider->getAll();
        }

        return [$user];
    }
}
