# Table des matières

1. Règles générales
1. Rapporter un bug/une idée
1. Développer une fonctionnalité
1. Qualité de code

## Règles générales

Vous avez décidé de contribuer à notre projet ? Tout d'abord, merci ! Ensuite, voici quelques règles à suivre :
* Toute nouvelle fonctionnalité doit faire l'objet préalable d'une demande et d'une validation par l'auteur de l'application (voir section "Rapporter un bug/une idée").
* Toute idée ou suggestion est bonne à prendre, nous vous faisons confiance pour une bonne entente et des échanges courtois sur vos issues et pull requests.


## Rapporter un bug/une idée

Vous avez identifié un bug ou souhaitez suggérer une idée de développement ? Très bien ! Néanmoins, il convient de respecter le processus suivant :
1. Rendez-vous sur le tableau de projet GitHub : https://github.com/quentinboinet/todoandco/projects/1
1. Identifiez la colonne "Ideas/Bugs"
1. Ajoutez votre suggestion ou bug en tant que nouvelle carte. Il est important alors d'y spécifier :
   * La date de rapport.
   * La fonctionnalité concernée par l'idée ou le bug.
   * Le fichier et ligne exacte d'apparition du bug.
   * Si déjà identifié, un descriptif de comment vous comptez résoudre ce bug/développer cette idée.
1. Une fois validé par un membre de la core team, suivez les étapes décrites dans la section "Développer une fonctionnalité" ci-dessous.

## Développer une fonctionnalité

Vous souhaitez apporter votre pière à l'édifice en développant une nouvelle fonctionnalité ? Votre suggestion a été approuvée ? Parfait ! Néanmoins, il convient de respecter le processus suivant :
1. Rendez-vous sur le dépôt GitHub du projet.
1. Créez et ouvrez une Issue correspondant à votre développement. Il est important d'y spécifier :
   * Le détail de la fonctionnalité développée.
   * Un descriptif rapide des principales étapes de développement.
   * Si c'est le cas, les bibiothèques externes qui seront utilisées et/ou installées.
1. Développez votre code.
1. Pushez votre code sur la branche correspondante (jamais sur la branche master directement !)
1. Demandez ensuite une pull request, qui sera validée ou non par l'équipe.
  
## Qualité de code

Afin de garantir et de maintenir un haut niveau de qualité de code, quelques règles sont à respecter dans votre développement :
* Le respect des principales recommandations en vigueur est obligatoire (W3C pour le HTML/CSS ou PSR pour le PHP)
* L'utilisation d'outils tels que PHP-CS-Fixer ou CodeClimate est fortement encouragé. Chaque pull request ou apport de nouveau code à l'application doit avoir fait l'objet d'analyse via un ou plusieurs de ces outils.
* Afin de maintenir le projet viable, le développement de tests unitaires et fonctionnels accompagnant vos ajouts est obligatoire. Ceux-ci devront être réalisés avec PHPUnit afin de maintenir une cohérence.
