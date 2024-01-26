<?php

namespace App\Repository;

use App\Entity\Drugs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Drugs>
 *
 * @method Drugs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drugs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drugs[]    findAll()
 * @method Drugs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrugsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drugs::class);
    }

//    /**
//     * @return Drugs[] Returns an array of Drugs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Drugs
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
