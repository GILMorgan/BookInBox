<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function save(Author $author): Author
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();

        return $author;
    }

    public function delete(Author $author): void
    {
        $this->getEntityManager()->remove($author);
        $this->getEntityManager()->flush();
    }

    public function countAll(): int
    {
        $res = $this->createQueryBuilder('a') 
            ->select('count(a.id) as c') 
            ->getQuery() 
            ->getSingleScalarResult(); 

        return intval($res); 
    }

    public function findPagined(int $page, int $nbResults = 25): array
    {
        $firstResult = ($page -1) * $nbResults;
        
        return $this->createQueryBuilder('a') 
            ->select('a')
            ->addOrderBy('a.name', 'ASC')
            ->addOrderBy('a.firstName', 'ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($nbResults)
            ->getQuery() 
            ->getResult();
    }
}
