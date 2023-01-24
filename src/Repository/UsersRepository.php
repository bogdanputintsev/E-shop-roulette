<?php

namespace App\Repository;

use App\Entity\Users;
use App\Interfaces\IUsersRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class UsersRepository extends ServiceEntityRepository implements IUsersRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function getUser($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb ->select('u.id', 'u.username', 'u.balance', 'u.daily_gift')
            ->where('u.id = ' . (int)$id);
        return $qb
            ->getQuery()
            ->getArrayResult();
    }

    public function updateBalance ($id, $balance, $realBalance)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->update( )
            ->set('u.balance', (int)$balance)
            ->set('u.balance_real', (int)$realBalance)
            ->where('u.id = ' . (int)$id)
            ->getQuery()->execute();
    }

    public function update ($uid, $difference)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->update( )
            ->set('u.balance', (int)$difference)
            ->where('u.id = ' . (int)$uid)
            ->getQuery()->execute();
    }

    public function useDailyGift($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->update()
            ->set('u.daily_gift',  1)
            ->where('u.id = ' . (int)$id )
            ->getQuery()->execute();
    }

    public function findVK($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.id', 'u.balance')
            ->where('u.vk_id = ' . (int)$id);
        return $qb->getQuery()->getSingleResult();
    }
}
