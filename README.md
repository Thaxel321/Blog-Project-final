# Blog-Project-final


# pre requis

php version : 8.0.18
composer version : 2.3.3


# installation

composer install

changer l'url pour la deb base dans .env (avec le nom futur de la db)

# commande pour creer la base de donnee
php bin/console doctrine:database:create

---

# commande pour creer les fichier sql

php bin/console make:migration

# executer les fichiers sql

php bin/console doctrine:migrations:migrate

# commande pour charger le jeu de fausse donnee

php bin/console doctrine:fixtures:load

#lancer le serveur avec php
php bin/console server:run


