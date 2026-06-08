<?php

namespace App\Repository;

use App\Entity\UserCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCollection::class);
    }

    public function save(UserCollection $userCollection): UserCollection
    {
        $this->getEntityManager()->persist($userCollection);
        $this->getEntityManager()->flush();

        return $userCollection;
    }

    public function countAllByUser(string $userId): int
    {
        $res = $this->createQueryBuilder('u') 
            ->select('count(u.id) as c') 
            ->where('u.userId LIKE :userId')
            ->setParameter('userId', $userId)
            ->getQuery() 
            ->getSingleScalarResult(); 

        return intval($res); 
 
    }
}

