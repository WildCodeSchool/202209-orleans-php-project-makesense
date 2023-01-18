<?php

namespace App\Repository;

use DateTime;
use App\Entity\Decision;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
        $queryBuilder = $this->createQueryBuilder('d');
        if ($searchedValue) {
            $queryBuilder->andWhere('d.title LIKE :searchedValue')
                ->setParameter('searchedValue', '%' . $searchedValue . '%');
        }
        $queryBuilder->orderBy('d.decisionStartTime', 'DESC')
            ->setMaxResults(12);

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function findDecisionFinished(DateTime $today, ?string $searchedValue = ''): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->andWhere('d.finalDecisionEndDate < :today')
            ->setParameter('today', $today);
        if ($searchedValue) {
            $queryBuilder->andWhere('d.title LIKE :searchedValue')
                ->setParameter('searchedValue', '%' . $searchedValue . '%');
        }

        $queryBuilder->orderBy('d.finalDecisionEndDate', 'DESC')
            ->setMaxResults(3);

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function findDecisionFinishedSoon(DateTime $today, ?string $searchedValue = ''): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->andWhere('d.finalDecisionEndDate > :today')
            ->setParameter('today', $today);
        if ($searchedValue) {
            $queryBuilder->andWhere('d.title LIKE :searchedValue')
                ->setParameter('searchedValue', '%' . $searchedValue . '%');
        }

        $queryBuilder->orderBy('d.finalDecisionEndDate', 'ASC')
            ->setMaxResults(3);

        return $queryBuilder->getQuery()
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
