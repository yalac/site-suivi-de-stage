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

    /**
     * Retourne les stages non-terminés (incluant les futurs)
     * Un stage est affiché si dateFinStage n'est pas passée
     */
    public function findCurrent(\DateTimeInterface $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');

        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.dateFinStage IS NULL OR s.dateFinStage >= :date')
            ->setParameter('date', $date, Types::DATE_IMMUTABLE)
            ->orderBy('s.dateDebutStage', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne les stages terminés à la date donnée (ou aujourd'hui si null)
     * Un stage est terminé si dateFinStage < date
     */
    public function findFinished(\DateTimeInterface $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');

        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.dateFinStage IS NOT NULL AND s.dateFinStage < :date')
            ->setParameter('date', $date, Types::DATE_IMMUTABLE)
            ->orderBy('s.dateFinStage', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne les stages qui ont effectivement un élève associé.
     */
    public function findWithEleve(): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.eleveStage', 'e')
            ->addSelect('e')
            ->orderBy('s.dateDebutStage', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
