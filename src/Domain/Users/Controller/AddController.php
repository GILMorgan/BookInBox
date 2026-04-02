<?php

namespace App\Domain\Users\Controller;

use App\Domain\Users\Contract\UserProviderInterface;
use App\Domain\Users\Exception\AllReadyExistException;
use App\Domain\Users\Exception\NotAuthorizedException;
use App\Domain\Users\DTO\User;

class AddController
{
    public function __construct(private readonly UserProviderInterface $userProvider)
    {
    }

    public function addUser(User $currentUser, User $newUser): bool
    {
        if (!in_array("ADMIN", $currentUser->roles)) {
            throw new NotAuthorizedException("You don't have enought permission to add a new user");
        }

        if ($this->userProvider->getByEmail($newUser->email)) {
            throw new AllReadyExistException("This email is allready used by another user");
        }

        $this->userProvider->save($newUser);

        return true;
    }
}
