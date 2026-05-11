<?php

namespace App\EventListener;

use App\Entity\Stage;
use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Entity\Entreprise;
use App\Entity\Historique;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::onFlush)]
class HistoriqueListener
{
    public function __construct(private Security $security)
    {
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Stage) {
                $this->persistHistory($em, $this->createHistory($entity, 'créé', 'stage'));
            } elseif ($entity instanceof Eleve) {
                $this->persistHistory($em, $this->createHistory($entity, 'créé', 'eleve'));
            } elseif ($entity instanceof Utilisateur) {
                $this->persistHistory($em, $this->createHistory($entity, 'créé', 'utilisateur'));
            } elseif ($entity instanceof Entreprise) {
                $this->persistHistory($em, $this->createHistory($entity, 'créé', 'entreprise'));
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $changeSet = $uow->getEntityChangeSet($entity);

            if ($entity instanceof Stage && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createHistory($entity, 'modifié', 'stage', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Eleve && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createHistory($entity, 'modifié', 'eleve', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Utilisateur && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createHistory($entity, 'modifié', 'utilisateur', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Entreprise && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createHistory($entity, 'modifié', 'entreprise', $field, $oldValue, $newValue));
                }
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof Stage) {
                $this->persistHistory($em, $this->createHistory($entity, 'supprimé', 'stage'));
            } elseif ($entity instanceof Eleve) {
                $this->persistHistory($em, $this->createHistory($entity, 'supprimé', 'eleve'));
            } elseif ($entity instanceof Utilisateur) {
                $this->persistHistory($em, $this->createHistory($entity, 'supprimé', 'utilisateur'));
            } elseif ($entity instanceof Entreprise) {
                $this->persistHistory($em, $this->createHistory($entity, 'supprimé', 'entreprise'));
            }
        }
    }

    private function getConnectedUser(): ?Utilisateur
    {
        $user = $this->security->getUser();
        return $user instanceof Utilisateur ? $user : null;
    }

    private function convertValueToString($value): ?string
    {
        if ($value === null) {
            return null;
        }
        if (is_bool($value)) {
            return $value ? 'oui' : 'non';
        }
        if ($value instanceof \DateTimeInterface) {
            return $value->format('d-m-Y H:i:s');
        }
        if (is_object($value)) {
            return (string) $value;
        }
        return (string) $value;
    }

    private function persistHistory(object $em, object $historique): void
    {
        $em->persist($historique);
        $em->getUnitOfWork()->computeChangeSet($em->getClassMetadata($historique::class), $historique);
    }

    private function createHistory(Stage|Eleve|Utilisateur|Entreprise $entity, string $typeAction, string $typeEntite, ?string $field = null, mixed $oldValue = null, mixed $newValue = null): Historique
    {
        if ($typeAction === 'créé' && $oldValue === null && $newValue === null) {
            $newValue = match ($entity::class) {
                Stage::class => $this->describeStage($entity),
                Eleve::class => $this->describeEleve($entity),
                Utilisateur::class => $this->describeUtilisateur($entity),
                Entreprise::class => $this->describeEntreprise($entity),
            };
        } elseif ($typeAction === 'supprimé' && $oldValue === null && $newValue === null) {
            $oldValue = match ($entity::class) {
                Stage::class => $this->describeStage($entity),
                Eleve::class => $this->describeEleve($entity),
                Utilisateur::class => $this->describeUtilisateur($entity),
                Entreprise::class => $this->describeEntreprise($entity),
            };
        }

        $historique = new Historique();
        
        if ($entity instanceof Stage) {
            $historique->setStage($entity);
        } elseif ($entity instanceof Eleve) {
            $historique->setEleve($entity);
        } elseif ($entity instanceof Utilisateur) {
            $historique->setUtilisateur($this->getConnectedUser());
        } elseif ($entity instanceof Entreprise) {
            $historique->setEntreprise($entity);
        }
        
        if (!($entity instanceof Utilisateur)) {
            $historique->setUtilisateur($this->getConnectedUser());
        }
        
        $historique->setDateModification(new \DateTimeImmutable());
        $historique->setTypeAction($typeAction);
        $historique->setTypeEntite($typeEntite);
        $historique->setChampModifie($field);
        $historique->setAncienneValeur($this->convertValueToString($oldValue));
        $historique->setNouvelleValeur($this->convertValueToString($newValue));

        return $historique;
    }

    private function describeStage(Stage $stage): string
    {
        return $this->buildSnapshot([
            'Élève: '.($stage->getEleveStage() ? $stage->getEleveStage()->getPrenomEleve().' '.$stage->getEleveStage()->getNomEleve() : 'Aucun'),
            'Entreprise: '.($stage->getEntrepriseStage() ? $stage->getEntrepriseStage()->getNomEntreprise() : 'Aucune'),
            'Début: '.($stage->getDateDebutStage()?->format('d/m/Y') ?? '—'),
            'Fin: '.($stage->getDateFinStage()?->format('d/m/Y') ?? '—'),
            'Référent: '.($stage->getProfReferent() ?? '—'),
            'Visite: '.($stage->getProfVisite() ?? '—'),
            'Description: '.($stage->getDescriptifStage() ?? '—'),
        ]);
    }

    private function describeEleve(Eleve $eleve): string
    {
        return $this->buildSnapshot([
            'Nom: '.($eleve->getNomEleve() ?? '—'),
            'Prénom: '.($eleve->getPrenomEleve() ?? '—'),
            'Option: '.($eleve->getOptionEleve() ? (string) $eleve->getOptionEleve() : '—'),
            'Promotion: '.($eleve->getPromotionEleve() ? (string) $eleve->getPromotionEleve() : '—'),
        ]);
    }

    private function describeUtilisateur(Utilisateur $utilisateur): string
    {
        return $this->buildSnapshot([
            'Nom: '.($utilisateur->getNomUtilisateur() ?? '—'),
            'Prénom: '.($utilisateur->getPrenomUtilisateur() ?? '—'),
            'Email: '.($utilisateur->getEmailUtilisateur() ?? '—'),
            'Rôle: '.($utilisateur->getRoleUtilisateur() ? (string) $utilisateur->getRoleUtilisateur() : '—'),
        ]);
    }

    private function describeEntreprise(Entreprise $entreprise): string
    {
        return $this->buildSnapshot([
            'Nom: '.($entreprise->getNomEntreprise() ?? '—'),
            'Adresse: '.($entreprise->getAdresseEntreprise() ?? '—'),
            'CP: '.($entreprise->getCpEntreprise() ?? '—'),
            'Ville: '.($entreprise->getVilleEntreprise() ?? '—'),
            'Tuteur: '.($entreprise->getTuteurEntreprise() ?? '—'),
            'Téléphone: '.($entreprise->getTelephoneEntreprise() ?? '—'),
            'Mail: '.($entreprise->getMailEntreprise() ?? '—'),
        ]);
    }

    private function buildSnapshot(array $parts): string
    {
        return implode(' | ', array_values(array_filter($parts, static fn (?string $part): bool => $part !== null && $part !== '')));
    }
}
