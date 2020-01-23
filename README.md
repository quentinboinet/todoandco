To Do List
========

Ce dépôt contient le code du projet 8 réalisé durant ma formation de développpeur PHP/Symfony à OpenClassrooms.
Le projet est une application de To Do list et présente les fonctionnalités suivantes :
* Espace utilisateur
* Espace utilisateurs admin permettant de modifier les autres utilisateurs
* Ajout, édition et suppression de tâches à faire
* Possibilité de marquer une tâche en terminée
* Visualisation de la liste des tâches à faire/terminées

[![Maintainability](https://api.codeclimate.com/v1/badges/ee6923ebf98a9189f078/maintainability)](https://codeclimate.com/github/quentinboinet/todoandco/maintainability)

## Installation

1. Clonez ou téléchargez le contenu du dépôt GitHub avec :
```bash
git clone https://github.com/quentinboinet/todoandco.git 
```
2. Editez le fichier situé à la racine intitulé ".env" afin de remplacer les valeurs de paramétrage de la base de données et du serveur de mail.
3.Installez les dépendances du projet avec :
```bash
composer install
```
4. Créez la base de données avec la commande suivante :
```bash
php bin/console doctrine:database:create
```
5. Lancer les migrations avec la commande : 
```bash
php bin/console doctrine:migrations:migrate
```
6. Importez ensuite le jeu de données initiales avec : 
```bash
php bin/console hautelook:fixtures:load
```
7. Afin de lancer le serveur, lancez la commande :
```bash
php bin/console server:run
```

Bravo, l'application est désormais accessible à l'adresse : localhost:8000 !

## Tests

Si vous souhaitez lancer les tests unitaires et fonctionnels et créer un rapport de couverture de code, lancez la commande suivante à la racine du projet : 
```bash
php bin/phpunit --coverage-html web/test-coverage
```
Le rapport sera produit en HTML et disponible dans le dossier web/test-coverage.

## Contribuer

Afin de contribuer à ce projet, merci de lire les instructions contenues dans contributing.md
