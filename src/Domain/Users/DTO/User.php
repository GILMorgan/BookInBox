<?php

namespace App\Domain\Users\DTO;

final class User
{
    public string $id;
    public string $email;
    public array $roles;
    public string $password;
    public bool $isDeleted;
}
