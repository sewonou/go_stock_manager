<?php

namespace App\Repository;

use App\Entity\SaveLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SaveLine>
 *
 * @method SaveLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaveLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaveLine[]    findAll()
 * @method SaveLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaveLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaveLine::class);
    }

//    /**
//     * @return SaveLine[] Returns an array of SaveLine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SaveLine
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
