<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $hashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setMdpUtilisateur($hashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findProfFullNames(): array
    {
        $rows = $this->createQueryBuilder('utilisateur')
            ->select("CONCAT(utilisateur.prenomUtilisateur, ' ', utilisateur.nomUtilisateur) AS nomComplet")
            ->join('utilisateur.roleUtilisateur', 'role')
            ->where("UPPER(role.nomRole) = :prof")
            ->setParameter('prof', 'PROF')
            ->orderBy('nomComplet', 'ASC')
            ->getQuery()
            ->getScalarResult();

        return array_map(static fn (array $row): string => $row['nomComplet'], $rows);
    }
}
