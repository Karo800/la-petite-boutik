<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

public function findByGender(string $gender): array
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.gender = :gender')
        ->setParameter('gender', $gender)
        ->orderBy('p.name', 'ASC')
        ->getQuery()
        ->getResult();
}

}





   
