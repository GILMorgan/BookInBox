<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = $this->getAdminUser();

        $manager->persist($admin);
        $manager->flush();
    
        for ($i=0; $i<10; $i++) {
            $user = $this->getNormalUser($i);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getAdminUser(): User
    {
        $user = new User();
        $user
            ->setId((string) Uuid::v4())
            ->setEmail("admin@bookinbox.com")
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"]);

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            "admin"
        );
        $user->setPassword($hashedPassword);

        return $user;
    }

    private function getNormalUser(int $number): User
    {
        $user = new User();
        $user
            ->setId((string) Uuid::v4())
            ->setEmail("user_" . $number . "@bookinbox.com")
            ->setRoles(["ROLE_USER"]);

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            "user_" . $number
        );
        $user->setPassword($hashedPassword);

        return $user;

    }
}
