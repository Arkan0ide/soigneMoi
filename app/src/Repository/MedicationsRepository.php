<?php

namespace App\Repository;

use App\Entity\Medications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medications>
 *
 * @method Medications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medications[]    findAll()
 * @method Medications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medications::class);
    }

//    /**
//     * @return Medications[] Returns an array of Medications objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Medications
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
