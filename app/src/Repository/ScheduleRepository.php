<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedule>
 *
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    // Returns list of patients for authenticated doctor
    public function findPatientByDoctor($doctor): array
    {
        $day = new \DateTimeImmutable('now');
        $startOfDay = $day->setTime(0, 0, 0);
        $endOfDay = $day->setTime(23, 59, 59);
        $day = $day->format('Y-m-d');
        return $this->createQueryBuilder('s')
            ->where('s.doctor = :doctor')
            ->andWhere('(:startOfToday <= s.dateTimeBegin AND :endOfToday >= s.dateTimeEnd)')
            ->setParameter('doctor', $doctor)
            ->setParameter('endOfToday', $endOfDay)
            ->setParameter('startOfToday', $startOfDay)
            ->orderBy('s.dateTimeBegin', 'ASC')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Schedule[] Returns an array of Schedule objects
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

//    public function findOneBySomeField($value): ?Schedule
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
