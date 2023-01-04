<?php

namespace App\Repository;

use App\Entity\Decision;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Decision>
 *
 * @method Decision|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decision|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decision[]    findAll()
 * @method Decision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decision::class);
    }

    public function save(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Decision[] Returns an array of Decision objects
    //     */
    public function decisionSearch(?string $searchedValue): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.title LIKE :searchedValue')
            ->setParameter('searchedValue', '%' . $searchedValue . '%')
            ->orderBy('d.decisionStartTime', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findDecisionFinishedSoon(DateTime $today, ?string $searchedValue = ''): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.finalDecisionEndDate < :today')
            ->setParameter('today', $today)
            ->andWhere('d.title LIKE :searchedValue')
            ->setParameter('searchedValue', '%' . $searchedValue . '%')
            ->orderBy('d.finalDecisionEndDate', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Decision
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
