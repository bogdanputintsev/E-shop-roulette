<?php

namespace App\Repository;

use App\Entity\UsersOnline;
use App\Interfaces\IUsersOnlineRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersOnline|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersOnline|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersOnline[]    findAll()
 * @method UsersOnline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersOnlineRepository extends ServiceEntityRepository implements IUsersOnlineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersOnline::class);
    }

    public function findMyself($session)
    {
        return $this->createQueryBuilder('p')
                ->select('count(p.id)')
                ->where('p.session = \'' . $session . '\'')
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function findInactive($time)
    {
        $this->createQueryBuilder('n')
            -> delete()
            -> where('n.time < :time')
            -> setParameter('time', (int)$time - 10)
            -> getQuery()
            -> execute();
    }

    public function findCount($session, $time)
    {
        $this->findInactive($time);

        if ( $this->findMyself($session) == true )
        {
           $qb = $this->createQueryBuilder('p');
           $qb->update()
               ->set('p.time', (int)$time)
               ->where('p.session = \'' . $session . '\'')
               ->getQuery()->execute();
        }

        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
