# Document utilisateur - Site de suivi de stage

## 1. Présentation

Le **Site de suivi de stage** est une application web Symfony qui permet de gérer :

- les élèves,
- les entreprises d'accueil,
- les stages,
- le suivi des visites,
- l'historique des modifications.

Cette documentation explique comment se connecter, naviguer dans l'application et utiliser les principales fonctionnalités.

## 2. Accès à l'application

### Adresse du site

En local, le site est généralement accessible à l'adresse :

- `http://localhost:8000/`

Cette adresse ouvre la page de connexion.

### Pré-requis

Pour utiliser l'application, il faut :

- un compte utilisateur déjà créé,
- un navigateur récent,
- une connexion au serveur de l'application et à la base de données.

### Connexion

La page de connexion permet de saisir :

- l'adresse e-mail,
- le mot de passe.

Si l'utilisateur est déjà connecté et ouvre la page de connexion, il est redirigé vers le tableau de bord.

### Déconnexion

La déconnexion se fait via le lien présent dans le menu de l'application.

## 3. Connexion et droits d'accès

L'application utilise plusieurs niveaux d'accès.

- Les pages de consultation et de suivi peuvent être accessibles selon le rôle de l'utilisateur.
- Les pages d'administration, comme la gestion des utilisateurs, des entreprises, des stages et de l'historique, sont réservées aux administrateurs.
- Si l'utilisateur n'a pas les droits nécessaires, il est redirigé vers la page **Accès refusé**.

## 4. Navigation générale

Une fois connecté, l'utilisateur accède à un menu principal contenant généralement :

- **Tableau de bord**,
- **Utilisateurs**,
- **Entreprises**,
- **Stages**,
- **Suivi des visites**,
- **Historique**,
- **Déconnexion**.

Le tableau de bord centralise les informations principales du suivi de stage.

## 5. Tableau de bord

### URL

- `/dashboard`

### Rôle de la page

Le tableau de bord affiche une vue d'ensemble de l'application, avec notamment :

- le nombre d'entreprises,
- le nombre de stages,
- des raccourcis vers les différentes sections.

### Utilisation

Cette page sert de point d'entrée après la connexion. Elle permet de repérer rapidement l'état général des données de suivi.

## 6. Gestion des utilisateurs

### URL principale

- `/utilisateurs`

### Accès

Cette section est réservée aux administrateurs.

### Contenu de la page

La page affiche :

- la liste des élèves,
- la liste des utilisateurs,
- des actions pour consulter, modifier ou supprimer les fiches.

### Actions possibles

Depuis cette section, un administrateur peut :

- créer un élève,
- consulter la fiche d'un élève,
- modifier un élève,
- supprimer un élève,
- créer un utilisateur,
- consulter la fiche d'un utilisateur,
- modifier un utilisateur,
- supprimer un utilisateur.

### Création d'un élève

#### URL

- `/newEleve`

#### Champs à renseigner

- nom,
- prénom,
- option,
- promotion.

#### Règles

- l'option et la promotion doivent être choisies dans les listes proposées,
- les champs nom et prénom sont obligatoires.

### Fiche d'un élève

#### URL

- `/Eleve/{id}`

Cette page affiche les informations de l'élève sélectionné.

### Modification d'un élève

#### URL

- `/Eleve/{id}/edit`

Permet de mettre à jour les informations de l'élève.

### Suppression d'un élève

#### URL

- `/Eleve/{id}`

La suppression se fait via un formulaire de confirmation.

Si l'élève est déjà lié à un stage, la suppression peut être refusée.

### Création d'un utilisateur

#### URL

- `/newUtilisateur`

#### Champs à renseigner

- nom,
- prénom,
- adresse e-mail,
- rôle,
- mot de passe lors de la création.

#### Règles

- l'adresse e-mail doit être valide,
- le rôle doit être sélectionné dans la liste,
- le mot de passe est obligatoire lors de la création,
- le mot de passe est chiffré avant enregistrement.

### Fiche d'un utilisateur

#### URL

- `/Utilisateur/{id}`

Cette page affiche les informations du compte utilisateur.

### Modification d'un utilisateur

#### URL

- `/Utilisateur/{id}/edit`

Permet de modifier les informations du compte.

Lors d'une modification, le mot de passe peut ne pas être demandé selon le formulaire utilisé.

### Suppression d'un utilisateur

#### URL

- `/Utilisateur/{id}`

La suppression se fait via un formulaire avec validation.

### Gestion des rôles

Les rôles sont sélectionnés depuis la base de données. Ils servent à définir les droits d'accès dans l'application.

## 7. Gestion des entreprises

### URL principale

- `/entreprise`

### Accès

Cette section est réservée aux administrateurs.

### Contenu de la page

La page affiche la liste des entreprises enregistrées.

### Actions possibles

Depuis cette section, un administrateur peut :

- créer une entreprise,
- consulter une entreprise,
- modifier une entreprise,
- supprimer une entreprise.

### Création d'une entreprise

#### URL

- `/entreprise/new`

#### Champs à renseigner

- nom de l'entreprise,
- adresse,
- ville,
- code postal,
- tuteur,
- téléphone,
- adresse e-mail.

#### Règles

- le code postal doit être un nombre,
- l'adresse e-mail doit être valide,
- les champs obligatoires doivent être renseignés.

### Fiche d'une entreprise

#### URL

- `/entreprise/{id}`

Cette page affiche les informations détaillées de l'entreprise.

### Modification d'une entreprise

#### URL

- `/entreprise/{id}/edit`

Permet de corriger ou mettre à jour les coordonnées de l'entreprise.

### Suppression d'une entreprise

#### URL

- `/entreprise/{id}`

La suppression est refusée si l'entreprise est déjà associée à un stage.

## 8. Gestion des stages

### URL principale

- `/stages`

### Accès

Cette section est réservée aux administrateurs.

### Contenu de la page

La page liste les stages enregistrés dans l'application.

### Actions possibles

Depuis cette section, un administrateur peut :

- créer un stage,
- consulter un stage,
- modifier un stage,
- supprimer un stage.

### Création d'un stage

#### URL

- `/stages/new`

#### Champs à renseigner

- élève,
- date de début,
- date de fin,
- description courte,
- entreprise,
- professeur référent,
- professeur de visite.

#### Règles importantes

- un élève ne peut pas avoir plusieurs stages en même temps dans la sélection proposée,
- l'élève, l'entreprise et les dates doivent être renseignés,
- les professeurs sont choisis dans une liste prédéfinie.

### Fiche d'un stage

#### URL

- `/stages/{id}`

Cette page présente les détails du stage.

### Modification d'un stage

#### URL

- `/stages/{id}/edit`

Permet de modifier les informations du stage.

### Suppression d'un stage

#### URL

- `/stages/{id}`

La suppression se fait via un formulaire de confirmation.

## 9. Suivi des visites

### URL principale

- `/suivi-visites`

### Rôle de la page

Cette section affiche les stages avec leur commentaire de visite.

### Utilisation

L'utilisateur peut :

- consulter la liste des stages suivis,
- ouvrir la page de commentaire d'un stage,
- ajouter ou modifier un commentaire de visite.

### Commentaire d'un stage

#### URL

- `/suivi-visites/{id}/commentaire`

#### Fonctionnement

- ouvrir la page du stage,
- saisir ou modifier le commentaire,
- enregistrer.

Si le commentaire est laissé vide, il peut être supprimé.

## 10. Historique des modifications

### URL principale

- `/historique`

### Accès

Cette section est réservée aux administrateurs.

### Rôle de la page

L'historique affiche les actions enregistrées dans l'application, par exemple :

- création,
- modification,
- suppression.

Les entrées peuvent concerner :

- les stages,
- les élèves,
- les utilisateurs,
- les entreprises.

### Utilisation

L'administrateur peut :

- consulter les modifications,
- supprimer une entrée d'historique,
- supprimer tout l'historique.

### Suppression d'une entrée

#### URL

- `/historique/{type}/{id}/supprimer`

### Suppression complète

#### URL

- `/historique/tout-supprimer`

## 11. Page accès refusé

### URL

- `/access-denied`

Cette page s'affiche lorsqu'un utilisateur tente d'accéder à une fonctionnalité réservée à un autre rôle.

## 12. Déconnexion

### URL

- `/logout`

Cette URL permet de fermer la session de l'utilisateur.

La déconnexion est gérée par Symfony et ne renvoie pas vers une page de contenu spécifique.

## 13. Messages et validations fréquents

### Connexion

Si l'adresse e-mail ou le mot de passe est incorrect, un message d'erreur de connexion s'affiche.

### Formulaire entreprise

- l'e-mail doit être valide,
- le code postal doit contenir une valeur numérique.

### Formulaire utilisateur

- l'e-mail doit être valide,
- le rôle doit être sélectionné,
- le mot de passe est obligatoire lors de la création.

### Formulaire stage

- un élève déjà utilisé pour un stage peut être refusé dans la liste,
- l'entreprise doit être sélectionnée,
- les dates doivent être renseignées correctement.

## 14. Résumé des pages principales

- `/` ou `/login` : connexion,
- `/dashboard` : tableau de bord,
- `/utilisateurs` : gestion des élèves et des utilisateurs,
- `/entreprise` : gestion des entreprises,
- `/stages` : gestion des stages,
- `/suivi-visites` : suivi des visites,
- `/historique` : historique des modifications,
- `/access-denied` : accès refusé,
- `/logout` : déconnexion.

## 15. Support

En cas de difficulté :

- vérifier que le serveur est bien démarré,
- vérifier vos identifiants,
- vérifier que votre compte possède les bons droits,
- contacter l'administrateur de l'application si nécessaire.
