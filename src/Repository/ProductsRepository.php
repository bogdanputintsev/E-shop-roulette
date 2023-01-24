<?php

namespace App\Repository;

use App\Entity\Products;
use App\Interfaces\IProductsRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository implements IProductsRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function findProducts($products)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            -> select('p.id', 'p.name', 'p.image_key', 'p.price_sell', 'p.price', 'p.type', 'p.system', 'p.drop_chance')
            -> where ('p.id IN (:values)')
            -> setParameter( 'values', explode(',', $products));
        return $qb->getQuery()->getArrayResult();
    }

    public function findAllProductsInShop()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p.id', 'p.name', 'p.image_key', 'p.price', 'p.type', 'p.visible')
            ->where('p.type = 1')
            ->andWhere('p.visible = 1');
        return $qb->getQuery()->getArrayResult();
    }

    public function findAllAccountsInShop()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p.id', 'p.name', 'p.image_key', 'p.price', 'p.type', 'p.visible')
            ->where('p.type = 2')
            ->andWhere('p.visible = 1');
        return $qb->getQuery()->getArrayResult();
    }

    public function findGame($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.id = '.(int)$id);
        return $qb->getQuery()->getArrayResult();
    }

}
