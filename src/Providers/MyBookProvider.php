<?php

namespace App\Providers;

use App\Repository\BookRepository;
use App\Repository\UserCollectionRepository;
use App\Services\Books\BookSerializer;
use Symfony\Bundle\SecurityBundle\Security;

class MyBookProvider
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly UserCollectionRepository $userCollectionRepository,
        private readonly Security $security,
        private readonly BookSerializer $bookSerializer
    ) {
    }
    
    public function getPage(int $page): array
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new \Exception("Not connected");
        }

        $userId = $user->getId();

        return array_map(
            function ($book) {
                return $this->bookSerializer->toDto($book);
            },
            $this->bookRepository->findPaginedFromUser($userId, $page)
        );    
    }

    public function getNbOfBooks(): int
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new \Exception("Not connected");
        }

        return $this->userCollectionRepository->countAllByUser($user->getId());
    }
}
