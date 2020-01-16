#ToDoList
========

Ce dépôt contient le code du projet 8 réalisé durant ma formation de développpeur PHP/Symfony à OpenClassrooms.
Le projet est une application de ToDo list et présente les fonctionnalités suivantes :
* Espace utilisateur
* Espace utilisateurs admin permettant de modifier les autres utilisateurs
* Ajout, édition et suppression de tâches à faire
* Possibilité de marquer une tâche en terminée
* Visualisation de la liste des tâches à faire/terminées

========

## Installation

1. Clonez ou téléchargez le contenu du dépôt GitHub : <i>git clone https://github.com/quentinboinet/todoandco.git</i>
1. Editez le fichier situé à la racine intitulé ".env" afin de remplacer les valeurs de paramétrage de la base de données et du serveur de mail.
1.Installez les dépendances du projet avec : <i>composer install</i>
1. Créez la base de données avec la commande suivante : <i>php bin/console doctrine:database:create</i>
1. Lancer les migrations avec la commande : <i>php bin/console doctrine:migrations:migrate</i>
1. Importez ensuite le jeu de données initiales avec : <i>php bin/console hautelook:fixtures:load</i>
1. Afin de lancer le serveur, lancez la commande <i>php bin/console server:run</i>

Bravo, l'application est désormais accessible à l'adresse : localhost:8000 !

========

## Contribuer
