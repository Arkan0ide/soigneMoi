<?php

namespace App\Repository;

use App\Entity\Visits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visits>
 *
 * @method Visits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visits[]    findAll()
 * @method Visits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visits::class);
    }


    // Returns list of patients for authenticated doctor
    public function findVisitsOfDay(): array
    {
        $day = new \DateTimeImmutable('now');
        $startOfDay = $day->setTime(0, 0, 0);
        $endOfDay = $day->setTime(23, 59, 59);
        return $this->createQueryBuilder('s')
            ->where('(s.startDate BETWEEN :startOfDay AND :endOfDay)')
            ->orWhere('(s.EndDate BETWEEN :startOfDay AND :endOfDay)')
            ->setParameter('endOfDay', $endOfDay)
            ->setParameter('startOfDay', $startOfDay)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Visits[] Returns an array of Visits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Visits
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
