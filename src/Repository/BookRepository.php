<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $book): Book
    {
        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();

        return $book;
    }

    public function delete(Book $book): void
    {
        $this->getEntityManager()->remove($book);
        $this->getEntityManager()->flush();
    }

    public function countAll(): int
    {
        $res = $this->createQueryBuilder('b') 
            ->select('count(b.id) as c') 
            ->getQuery() 
            ->getSingleScalarResult(); 

        return intval($res); 
    }

    public function sumAllPages(): int
    {
        $res = $this->createQueryBuilder('b') 
            ->select('sum(b.numberOfPages) as s') 
            ->getQuery() 
            ->getSingleScalarResult(); 

        return intval($res); 
    }

    public function findPagined(int $page, int $nbResults = 25): array
    {
        $firstResult = ($page -1) * $nbResults;

        return $this->createQueryBuilder('b') 
            ->select('b')
            ->leftJoin('b.authors', 'a')            
            ->orderBy('a.name', 'ASC')
            ->addOrderBy('b.serieName', 'ASC')
            ->addOrderBy('b.serieNumber', 'ASC')
            ->addOrderBy('b.title', 'ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($nbResults)
            ->getQuery() 
            ->getResult();
    }
}

