
# ALKOMA_JR_BLOG

## Pré-requis :

* PHP 7.4.9, MySQL 8.0.6, Apache 2.4.46

## Installation :

* Télécharger l'exécutable de composer et l'installer : https://getcomposer.org/download/ ;
* Télécharger l'exécutable de Wampserver et l'installer. Ledit serveur web à son installation vous configurera tout les élement lister dans les pré-requis : https://www.wampserver.com/ ;
* Lancer le serveur wamp ;
* Importer le fichier "/alkoma.sql" vers votre serveur de base de données via phpmyadmin (dbname:"alkoma" chez moi | localhost/phpmyadmin) ;
* Configurer la connexion à la base de donnée dans le fichier "/.env.example" en le renommant en ".env" ;
* Se rendre dans le navigateur et taper l'adresse suivante : http://localhost/alkoma_blog/.

## Authentifiction :

Après avoir crée la base de données avec les données importées pour se connecter en tant qu'admin utiliser les paramètres suivants :
* email : admin@alkoma.com
* password : alkoma