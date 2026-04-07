<?php

namespace App\Domain\Users\Controller;

use App\Domain\Users\Contract\UserProviderInterface;
use App\Domain\Users\Exception\NotAuthorizedException;
use App\Domain\Users\Exception\CurrentUserException;
use App\Domain\Users\DTO\User;

class DeleteController
{
    public function __construct(private readonly UserProviderInterface $userProvider)
    {
    }

    public function deleteUser(User $currentUser, $deleteUser): bool
    {
        if (!in_array("ADMIN", $currentUser->roles)) {
            throw new NotAuthorizedException();
        }

        if ($currentUser->id === $deleteUser->id) {
            throw new CurrentUserException();
        }

        $this->userProvider->delete($deleteUser);

        return true;
    }
}
