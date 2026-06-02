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
            ->addOrderBy("b.sortAuthors")
            ->addOrderBy("b.serieName")
            ->addOrderBy("b.serieNumber")
            ->addOrderBy("b.title")
            ->setFirstResult($firstResult)
            ->setMaxResults($nbResults)
            ->getQuery()
            ->getResult();
    }
}

