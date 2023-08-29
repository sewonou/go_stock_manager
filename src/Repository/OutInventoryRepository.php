<?php

namespace App\Repository;

use App\Entity\OutInventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutInventory>
 *
 * @method OutInventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutInventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutInventory[]    findAll()
 * @method OutInventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutInventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutInventory::class);
    }

//    /**
//     * @return OutInventory[] Returns an array of OutInventory objects
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

//    public function findOneBySomeField($value): ?OutInventory
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
