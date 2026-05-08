# Site de suivi de stage

Ce projet est une application Symfony permettant de gérer le suivi de stage. Ce README explique comment installer le projet en local, configurer la base de données, importer les données fournies et accéder au site.

La documentation utilisateur complète est disponible ici : [Document/LRR_siteSuiviStage_DU_docComplete_V2.md](Document/LRR_siteSuiviStage_DU_docComplete_V2.md).

## 1. Prérequis

Avant de commencer, il faut disposer de :

- PHP 8.1 ou supérieur,
- Composer,
- un serveur MySQL 8.x ou compatible,
- un navigateur web récent,
- un outil pour importer un fichier SQL, par exemple MySQL en ligne de commande, phpMyAdmin ou DBeaver.

## 2. Récupérer le projet

1. Ouvrir un terminal dans le dossier de travail.
2. Cloner le dépôt ou ouvrir le projet déjà présent sur la machine.
3. Se placer à la racine du projet `site-suivi-de-stage`.

Exemple :

```bash
git clone <URL_DU_DEPOT>
cd site-suivi-de-stage
```

## 3. Installer les dépendances

Installer les dépendances PHP avec Composer :

```bash
composer install
```

Cette commande installe les bibliothèques Symfony, Doctrine et Twig nécessaires au projet.

## 4. Configurer l'environnement

Le projet utilise une base MySQL configurée dans le fichier `.env` avec la variable `DATABASE_URL`.

Configuration actuelle prévue pour le développement local :

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/lrr_suiviestage?serverVersion=8.3.0&charset=utf8mb4"
```

Si votre MySQL utilise un autre utilisateur, mot de passe, hôte ou port, modifiez cette valeur dans `.env.local` plutôt que dans `.env`.

## 5. Créer et importer la base de données

Le dossier `Document/sql/` contient un dump complet de la base :

- [Document/sql/LRR_siteSuiviDeStage_DB_baseDeDonnee_V2.sql](Document/sql/LRR_siteSuiviDeStage_DB_baseDeDonnee_V2.sql)

### Option recommandée : importer le dump fourni

1. Créer la base `lrr_suiviestage` dans MySQL si elle n’existe pas déjà.
2. Importer le fichier SQL fourni.

Exemple en ligne de commande :

```bash
mysql -u root -p < Document/sql/LRR_siteSuiviDeStage_DB_baseDeDonnee_V2.sql
```

Si vous utilisez phpMyAdmin :

1. Ouvrir phpMyAdmin.
2. Sélectionner ou créer la base `lrr_suiviestage`.
3. Aller dans l’onglet d’import.
4. Choisir le fichier `Document/sql/LRR_siteSuiviDeStage_DB_baseDeDonnee_V2.sql`.
5. Lancer l’import.

### Option alternative : repartir d’une base vide

Si vous ne souhaitez pas utiliser le dump, vous pouvez créer une base vide puis exécuter les migrations Doctrine :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Cette option ne charge pas les données de démonstration présentes dans le dump SQL.

## 6. Vider le cache Symfony

Après l’installation et la configuration, vider le cache :

```bash
php bin/console cache:clear
```

## 7. Lancer le site

Vous pouvez démarrer l’application de deux façons.

### Avec Symfony CLI

```bash
symfony server:start
```

### Avec le serveur PHP intégré

```bash
php -S 127.0.0.1:8000 -t public
```

## 8. Accéder à l’application

Une fois le serveur lancé, ouvrir le site dans le navigateur :

```text
http://127.0.0.1:8000/
```

Pages utiles :

- connexion : `/login`,
- inscription : `/register`,
- déconnexion : `/logout`.

## 9. Résumé rapide

1. Installer PHP, Composer et MySQL.
2. Exécuter `composer install`.
3. Vérifier la variable `DATABASE_URL`.
4. Importer `Document/sql/LRR_siteSuiviDeStage_DB_baseDeDonnee_V2.sql` dans MySQL.
5. Vider le cache Symfony.
6. Lancer le serveur.
7. Ouvrir `http://127.0.0.1:8000/`.

## 10. Remarques

- Le dump SQL contient la structure de la base et des données de test.
- Si la connexion à la base échoue, vérifier que MySQL est bien démarré et que les paramètres de connexion correspondent à votre environnement.
- Si vous changez le schéma de la base, pensez à réimporter le dump ou à relancer les migrations selon votre méthode d’installation.
