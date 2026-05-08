<?php

namespace App\EventListener;

use App\Entity\Stage;
use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Entity\Entreprise;
use App\Entity\HistoriqueStage;
use App\Entity\HistoriqueEleve;
use App\Entity\HistoriqueUtilisateur;
use App\Entity\HistoriqueEntreprise;
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
                $this->persistHistory($em, $this->createStageHistory($entity, 'créé'));
            } elseif ($entity instanceof Eleve) {
                $this->persistHistory($em, $this->createEleveHistory($entity, 'créé'));
            } elseif ($entity instanceof Utilisateur) {
                $this->persistHistory($em, $this->createUtilisateurHistory($entity, 'créé'));
            } elseif ($entity instanceof Entreprise) {
                $this->persistHistory($em, $this->createEntrepriseHistory($entity, 'créé'));
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $changeSet = $uow->getEntityChangeSet($entity);

            if ($entity instanceof Stage && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createStageHistory($entity, 'modifié', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Eleve && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createEleveHistory($entity, 'modifié', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Utilisateur && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createUtilisateurHistory($entity, 'modifié', $field, $oldValue, $newValue));
                }
            } elseif ($entity instanceof Entreprise && !empty($changeSet)) {
                foreach ($changeSet as $field => [$oldValue, $newValue]) {
                    $this->persistHistory($em, $this->createEntrepriseHistory($entity, 'modifié', $field, $oldValue, $newValue));
                }
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof Stage) {
                $this->persistHistory($em, $this->createStageHistory($entity, 'supprimé'));
            } elseif ($entity instanceof Eleve) {
                $this->persistHistory($em, $this->createEleveHistory($entity, 'supprimé'));
            } elseif ($entity instanceof Utilisateur) {
                $this->persistHistory($em, $this->createUtilisateurHistory($entity, 'supprimé'));
            } elseif ($entity instanceof Entreprise) {
                $this->persistHistory($em, $this->createEntrepriseHistory($entity, 'supprimé'));
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

    private function createStageHistory(Stage $stage, string $typeAction, ?string $field = null, mixed $oldValue = null, mixed $newValue = null): HistoriqueStage
    {
        if ($typeAction === 'créé' && $oldValue === null && $newValue === null) {
            $newValue = $this->describeStage($stage);
        } elseif ($typeAction === 'supprimé' && $oldValue === null && $newValue === null) {
            $oldValue = $this->describeStage($stage);
        }

        $historique = new HistoriqueStage();
        $historique->setStage($stage);
        $historique->setUtilisateur($this->getConnectedUser());
        $historique->setDateModification(new \DateTimeImmutable());
        $historique->setTypeAction($typeAction);
        $historique->setChampModifie($field);
        $historique->setAncienneValeur($this->convertValueToString($oldValue));
        $historique->setNouvelleValeur($this->convertValueToString($newValue));

        return $historique;
    }

    private function createEleveHistory(Eleve $eleve, string $typeAction, ?string $field = null, mixed $oldValue = null, mixed $newValue = null): HistoriqueEleve
    {
        if ($typeAction === 'créé' && $oldValue === null && $newValue === null) {
            $newValue = $this->describeEleve($eleve);
        } elseif ($typeAction === 'supprimé' && $oldValue === null && $newValue === null) {
            $oldValue = $this->describeEleve($eleve);
        }

        $historique = new HistoriqueEleve();
        $historique->setEleve($eleve);
        $historique->setUtilisateur($this->getConnectedUser());
        $historique->setDateModification(new \DateTimeImmutable());
        $historique->setTypeAction($typeAction);
        $historique->setChampModifie($field);
        $historique->setAncienneValeur($this->convertValueToString($oldValue));
        $historique->setNouvelleValeur($this->convertValueToString($newValue));

        return $historique;
    }

    private function createUtilisateurHistory(Utilisateur $utilisateur, string $typeAction, ?string $field = null, mixed $oldValue = null, mixed $newValue = null): HistoriqueUtilisateur
    {
        if ($typeAction === 'créé' && $oldValue === null && $newValue === null) {
            $newValue = $this->describeUtilisateur($utilisateur);
        } elseif ($typeAction === 'supprimé' && $oldValue === null && $newValue === null) {
            $oldValue = $this->describeUtilisateur($utilisateur);
        }

        $historique = new HistoriqueUtilisateur();
        $historique->setUtilisateur($this->getConnectedUser());
        $historique->setDateModification(new \DateTimeImmutable());
        $historique->setTypeAction($typeAction);
        $historique->setChampModifie($field);
        $historique->setAncienneValeur($this->convertValueToString($oldValue));
        $historique->setNouvelleValeur($this->convertValueToString($newValue));

        return $historique;
    }

    private function createEntrepriseHistory(Entreprise $entreprise, string $typeAction, ?string $field = null, mixed $oldValue = null, mixed $newValue = null): HistoriqueEntreprise
    {
        if ($typeAction === 'créé' && $oldValue === null && $newValue === null) {
            $newValue = $this->describeEntreprise($entreprise);
        } elseif ($typeAction === 'supprimé' && $oldValue === null && $newValue === null) {
            $oldValue = $this->describeEntreprise($entreprise);
        }

        $historique = new HistoriqueEntreprise();
        $historique->setEntreprise($entreprise);
        $historique->setUtilisateur($this->getConnectedUser());
        $historique->setDateModification(new \DateTimeImmutable());
        $historique->setTypeAction($typeAction);
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
