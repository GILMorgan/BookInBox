<?php

namespace App\Providers;

use App\Domain\Users\DTO\User;
use App\Domain\Users\Contract\UserProviderInterface;
use App\Repository\UserRepository;
use App\Services\Users\UserSerializer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserSerializer $userSerializer,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function getAll(): array
    {
        return array_map(
            function ($user) {
                return $this->userSerializer->toDto($user);
            },
            $this->userRepository->findAll(),
        );
    }

    public function get(string $id): ?User
    {
        if ($user = $this->userRepository->find($id)) {
            return $this->userSerializer->toDto($user);
        }

        return null;
    }

    public function getByEmail(string $email): ?User
    {
        if ($user = $this->userRepository->findOneByEmail($email)) {
            return $this->userSerializer->toDto($user);
        }

        return null;
    }

    public function add(User $user): User
    {
        $entity = $this->userSerializer->toEntity($user);
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $entity,
            $user->password
        );
        $entity->setPassword($hashedPassword);

        $this->userRepository->save($entity);

        return $user;
    }

    public function update(User $user): User
    {
        throw new \Exception("Not implemented yet");

        return $user;
    }

    /**
     * Not a real delete but a soft delete only
     */ 
    public function delete(User $user): User
    {
        $entity = $this->userRepository->find($user->id);
        $entity->setDeleted(true);

        $this->userRepository->save($entity);

        return $user;
    }
}
