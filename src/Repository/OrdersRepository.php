<?php

namespace App\Repository;

use App\Entity\Orders;
use App\Interfaces\IOrdersRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository implements IOrdersRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function winningsCount()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.show_in_tape = 1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function livetape()
    {
        $qb = $this->createQueryBuilder('uo');
        $qb
            ->select('u.username', 'p.image_key', 'uo.date')
            ->innerJoin('App\Entity\Users', 'u', 'WITH', 'u = uo.user_id')
            ->innerJoin('App\Entity\Products', 'p', 'WITH', 'p = uo.product_id')
            ->where('uo.show_in_tape = 1')
            ->orderBy('uo.date', 'DESC');

        return $qb->getQuery()->setMaxResults(11)->getResult();
    }

    public function lastID($uid)
    {
        $qb = $this->createQueryBuilder('uo');
        $qb -> select('uo.id')
            ->where('uo.user_id = '. (int)$uid)
            ->orderBy('uo.id', 'DESC');
        return $qb->getQuery()->setMaxResults(1)->getSingleScalarResult();
    }

    public function takeKey($value, $lastID)
    {
        $qb = $this->createQueryBuilder('uo');
        $qb->update()
            ->set('uo.info', '\''.$value.'\'')
            ->where('uo.id = ' . (int)$lastID)
            ->getQuery()->execute();
    }

    public function findByUser($user_id)
    {
        $qb = $this->createQueryBuilder('uo');
        if ($user_id != "")
        {
            $qb
                ->select('p.name', 'uo.info', 'uo.date')
                ->innerJoin('App\Entity\Products', 'p', 'WITH', 'p = uo.product_id')
                ->where('uo.user_id = ' . (int)$user_id)
                ->orderBy('uo.id', 'DESC');
        }
        return $qb->getQuery()->getArrayResult();
    }

    public function setKey($uid, $msg)
    {
        $qb = $this->createQueryBuilder('uo');
        $qb
            ->update()
            ->set('uo.info', $msg)
            ->where('uo.user_id = '.(int)$uid )
            ->getQuery()->execute();
    }
}
