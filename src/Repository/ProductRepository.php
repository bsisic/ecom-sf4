<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[]
     */
    public function findAllActive(): array
    {
        return $this->findProductActiveQuery()
            ->andWhere('p.price = 1000')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Product[]
     */
    public function findLatest(): array
    {
        return $this->findProductActiveQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;

    }

    private function findProductActiveQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.price > 0');
    }
}
