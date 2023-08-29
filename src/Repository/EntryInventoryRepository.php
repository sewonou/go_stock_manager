<?php

namespace App\Repository;

use App\Entity\EntryInventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntryInventory>
 *
 * @method EntryInventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntryInventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntryInventory[]    findAll()
 * @method EntryInventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryInventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntryInventory::class);
    }

//    /**
//     * @return EntryInventory[] Returns an array of EntryInventory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EntryInventory
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
