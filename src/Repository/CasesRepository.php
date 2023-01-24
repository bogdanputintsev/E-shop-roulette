<?php

namespace App\Repository;

use App\Entity\Cases;
use App\Interfaces\ICasesRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cases|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cases|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cases[]    findAll()
 * @method Cases[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasesRepository extends ServiceEntityRepository implements ICasesRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cases::class);
    }

    public function build ($id)
    {
        $qb = $this->createQueryBuilder('n');

        $qb ->select('n.id', 'n.name', 'n.description', 'n.price', 'n.products')
            ->where('n.id = ' . $id);
        return $qb
            ->getQuery()
            ->getArrayResult();
    }

    public function findCases()
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            -> select('c.id', 'c.name', 'c.price', 'c.game_id', 'p.image_key')
            -> innerJoin('App\Entity\Products', 'p', 'WITH', 'p = c.game_id')
            -> where('c.game_id IS NOT NULL')
            -> orderBy( 'c.popularity', 'DESC');
        return $qb-> getQuery()->getResult();
    }
}
