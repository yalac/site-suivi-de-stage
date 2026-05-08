<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Types\Types;

/**
 * @extends ServiceEntityRepository<Stage>
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findCurrent(?\DateTimeInterface $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFinStage IS NULL OR s.dateFinStage >= :date')
            ->setParameter('date', $date, Types::DATE_IMMUTABLE)
            ->orderBy('s.dateDebutStage', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findFinished(?\DateTimeInterface $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFinStage IS NOT NULL AND s.dateFinStage < :date')
            ->setParameter('date', $date, Types::DATE_IMMUTABLE)
            ->orderBy('s.dateFinStage', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findWithEleve(): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.eleveStage', 'e')
            ->addSelect('e')
            ->orderBy('s.dateDebutStage', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.dateDebutStage', 'DESC')
            ->addOrderBy('s.dateFinStage', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
