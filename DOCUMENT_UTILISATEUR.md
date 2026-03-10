# Document utilisateur - Site de suivi de stage

## 1. Objectif de l'application

Le **Site de suivi de stage** permet de gerer les comptes utilisateurs de la plateforme:

- creation d'un compte via un formulaire d'inscription,
- authentification via une page de connexion,
- deconnexion securisee.

Ce document explique comment utiliser ces fonctionnalites cote utilisateur.

## 2. Prerequis

Pour utiliser l'application, il faut:

- acceder a l'URL du site (fournie par votre etablissement ou votre administrateur),
- disposer d'un compte existant ou pouvoir en creer un,
- utiliser un navigateur web recent (Chrome, Firefox, Edge, etc.).

## 3. Acces a l'application

### Page de connexion

- URL: `/login`
- Champs demandes:
  - **Identifiant**: votre adresse e-mail,
  - **Mot de passe**: le mot de passe de votre compte.

### Page d'inscription

- URL: `/register`
- Permet de creer un nouveau compte utilisateur.

## 4. Creer un compte (inscription)

Sur la page `/register`, completer les champs suivants:

1. `nom`
2. `prenom`
3. `email`
4. `role` (selection dans la liste)
5. `password`
6. case d'acceptation des conditions

Regles de validation:

- l'e-mail est obligatoire et doit etre valide,
- l'e-mail doit etre unique (un seul compte par adresse e-mail),
- le mot de passe est obligatoire,
- le mot de passe doit contenir au moins 6 caracteres,
- la case d'acceptation doit etre cochee.

Une fois le formulaire valide:

- le compte est cree,
- le mot de passe est chiffre automatiquement,
- vous etes redirige vers la page de connexion.

## 5. Se connecter

Sur la page `/login`:

1. saisir votre adresse e-mail,
2. saisir votre mot de passe,
3. cliquer sur **Se connecter**.

Si les identifiants sont corrects, la session est ouverte.

Si les identifiants sont incorrects, un message d'erreur s'affiche:

- "Identifiants incorrects. Veuillez verifier votre email et votre mot de passe."

## 6. Se deconnecter

La deconnexion est disponible via la route `/logout` (utilisee par le lien de deconnexion quand l'utilisateur est connecte).

## 7. Gestion des roles

Lors de l'inscription, un role est selectionne depuis la base de donnees.

- Chaque utilisateur recoit automatiquement `ROLE_USER`.
- Le role choisi en base est ajoute aux roles de l'utilisateur (exemple: `ROLE_ADMIN`, `ROLE_PROF`, etc. selon les donnees configurees).

## 8. Messages et erreurs frequentes

- **"There is already an account with this email"**:
  - cette adresse e-mail est deja utilisee.
- **"Veuillez saisir une adresse e-mail valide."**:
  - le format de l'e-mail est invalide.
- **"Your password should be at least 6 characters"**:
  - le mot de passe est trop court.
- **"You should agree to our terms."**:
  - la case d'acceptation n'a pas ete cochee.

## 9. Limites actuelles

Dans la version actuelle:

- pas de fonctionnalite "mot de passe oublie",
- pas de page metier supplementaire exposee (hors inscription/connexion),
- pas de gestion utilisateur en self-service (modification profil/mot de passe) visible dans l'interface.

## 10. Support

En cas de probleme d'acces:

- verifier vos identifiants,
- verifier que votre compte existe,
- contacter l'administrateur de la plateforme ou le responsable pedagogique.
