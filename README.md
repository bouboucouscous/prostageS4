# prostages
Projet conducteur du module M3104 d'apprentissage de Symfony

Complet jusqu'au tp4 

Instructions
1. cloner ce projet `git clone ...`
2. installer symfony (depuis le bon répertoire `COMPOSER_MEMORY_LIMIT=-1 composer install`
3. configurer un fichier `.env.local` avec le bon accès à la base de données
4. créer les tables `php bin/console doctrine:migrations:migrate`
5. créer le jeu de données `php bin/console doctrine:fixtures:load` 
6. lancer le projet `php bin/console server:run` 
7. faire la suite des tps du module  
