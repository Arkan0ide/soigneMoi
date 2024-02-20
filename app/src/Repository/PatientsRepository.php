<?php

namespace App\Repository;

use App\Entity\Patients;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patients>
 *
 * @method Patients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patients[]    findAll()
 * @method Patients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patients::class);
    }


    public function findPatientDetails(int $idPatient, int $idVisit): ?Patients
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'v', 'pr', 'o')
            ->innerJoin('p.visits', 'v', 'WITH', 'v.id = :idVisit')
            ->leftJoin('p.prescriptions', 'pr') // Change innerJoin to leftJoin
            ->leftJoin('pr.opinion', 'o', 'WITH', 'o.date >= v.startDate AND o.date <= v.EndDate AND o.prescription = pr.id')
            ->where('p.id = :idPatient')
            ->setParameter('idPatient', $idPatient)
            ->setParameter('idVisit', $idVisit);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            // Handle the case where no patient or visit is found
            return null;
        }
    }




//    /**
//     * @return Patients[] Returns an array of Patients objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Patients
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
