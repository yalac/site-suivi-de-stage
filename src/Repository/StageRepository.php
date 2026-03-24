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
     * Retourne les stages en cours à la date donnée (ou aujourd'hui si null)
     * Un stage est en cours si dateDebut <= date AND (dateFin IS NULL OR dateFin >= date)
     */
    public function findCurrent(\DateTimeInterface $date = null): array
    {
        $date = $date ?? new \DateTimeImmutable('today');

        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut IS NULL OR s.dateDebut <= :date')
            ->andWhere('s.dateFin IS NULL OR s.dateFin >= :date')
            ->setParameter('date', $date, Types::DATE_IMMUTABLE)
            ->orderBy('s.dateDebut', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }
}
