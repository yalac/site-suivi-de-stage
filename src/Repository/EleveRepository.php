<?php

namespace App\Repository;

use App\Entity\Eleve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eleve>
 */
class EleveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleve::class);
    }

    public function createAvailableForStageQueryBuilder(?Eleve $currentEleve = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('eleve')
            ->leftJoin('eleve.stageEleve', 'stage')
            ->orderBy('eleve.nomEleve', 'ASC')
            ->addOrderBy('eleve.prenomEleve', 'ASC');

        if ($currentEleve !== null) {
            $queryBuilder
                ->andWhere('stage.id IS NULL OR eleve = :currentEleve')
                ->setParameter('currentEleve', $currentEleve);
        } else {
            $queryBuilder->andWhere('stage.id IS NULL');
        }

        return $queryBuilder;
    }
}
