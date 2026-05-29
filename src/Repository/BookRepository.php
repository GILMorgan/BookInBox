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

    /**
     * A simple query will be to complex for dql due to agregation (many to many join with authors)
     * the "in" function doesn't preserve order, so I have to loop manualy
     */ 
    public function findPagined(int $page, int $nbResults = 25): array
    {
        $firstResult = ($page -1) * $nbResults;

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            select 
                distinct(book_id), 
                a.name, 
                a.first_name, 
                b.serie_name,
                b.serie_number,
                b.title
            from book_author ba 
            inner join book b on b.id = ba.book_id 
            inner join author a on a.id = ba.author_id 
            order by a.name, a.first_name, b.serie_name, b.serie_number, b.title
            limit 25 
            offset 0
        ";

        $stmt = $conn->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        return array_map(
            function ($result) {
                return $this->find($result['book_id']);
            },
            $results
        );
    }
}

