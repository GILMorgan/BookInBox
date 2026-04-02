<?php

namespace App\Services\Users;

use App\Services\Users\UserSerializer;
use App\Domain\Users\DTO\User;
use Symfony\Bundle\SecurityBundle\Security;

final class CurrentUser
{
    public function __construct(
        private readonly Security $security,
        private readonly UserSerializer $userSerializer
    ) {
    }

    public function getUser(): User
    {
        return $this->userSerializer->toDto($this->security->getUser());
    }     
}
