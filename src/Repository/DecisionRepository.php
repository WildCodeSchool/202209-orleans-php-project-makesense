<?php

namespace App\Repository;

use App\Entity\Category;
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
    private const DECISION_LIMIT_ORDER = 4;
    private const ALL_DECISIONS_LIMIT_ORDER = 12;

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
            ->setMaxResults(self::ALL_DECISIONS_LIMIT_ORDER);

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function decisionSearchCategory(?string $searchedValue, ?Category $category): array
    {
        $queryBuilder = $this->createQueryBuilder('d');
        if ($searchedValue) {
            $queryBuilder
                ->andWhere('d.title LIKE :searchedValue')
                ->setParameter('searchedValue', '%' . $searchedValue . '%');
        }
        if ($category) {
            $queryBuilder
                ->join('d.category', 'c')
                ->andWhere('d.category = :category_id')
                ->setParameter('category_id', $category);
        }
        $queryBuilder->orderBy('d.decisionStartTime', 'DESC');

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
            ->setMaxResults(self::DECISION_LIMIT_ORDER);

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
            ->setMaxResults(self::DECISION_LIMIT_ORDER);

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
