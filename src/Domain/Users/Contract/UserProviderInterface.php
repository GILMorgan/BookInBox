<?php

namespace App\Domain\Users\Contract;

use App\Domain\Users\DTO\User;

interface UserProviderInterface
{
    public function getAll(): array;
    public function get(string $id): ?User;
    public function getByEmail(string $email): ?User;
    public function add(User $user): User;
    public function update(User $user): User;
    public function delete(User $user): User;
}
