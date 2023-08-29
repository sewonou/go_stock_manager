<?php

namespace App\Repository;

use App\Entity\OutInventoryLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutInventoryLine>
 *
 * @method OutInventoryLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutInventoryLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutInventoryLine[]    findAll()
 * @method OutInventoryLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutInventoryLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutInventoryLine::class);
    }

//    /**
//     * @return OutInventoryLine[] Returns an array of OutInventoryLine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OutInventoryLine
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
