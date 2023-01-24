<?php

namespace App\Repository;

use App\Entity\ProductsKeys;
use App\Interfaces\IProductsKeysRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductsKeys|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsKeys|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsKeys[]    findAll()
 * @method ProductsKeys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsKeysRepository extends ServiceEntityRepository implements IProductsKeysRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsKeys::class);
    }

    public function Use(?int $id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->update()
            ->set('p.is_used', true)
            ->where('p.id = ' . $id)
            ->getQuery()->execute();
    }

    public function isAvailable($id)
    {
        if ( $id == "" ){
            return false;
        }
        $qb = $this->createQueryBuilder('p');
        return $qb  ->select('count(p.id)')
                    ->where('p.product_id = ' . (int)$id )
                    ->getQuery()->getSingleResult() > 0;
    }

    public function findUnused($game_id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            -> select('p.id', 'p.value')
            -> where('p.daily_gift = 0')
            -> andWhere('p.product_id = '.(int)$game_id)
            -> andWhere('p.is_used = 0');
        return $qb->getQuery()->getArrayResult();
    }

    public function UseKey($msg)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->update()
            ->set('p.is_used', 1)
            ->where('p.value = \'' . $msg . '\'')
            ->getQuery()->execute();
    }
}
