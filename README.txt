
Ce projet a été réalisé dans pour être hébergé sur un NAS Synology. Il est donc prévu pour fonctionner avec PHP 8.0 et MariaDB 10.3.32. Cependant, il est possible de le faire fonctionner avec MySQL.
Le fichier config.php contient les identifiants pour se connecter à la base de données. Il n'est pas sur GitHub pour des raisons de sécurité.
Le fichier variables.php dans le dossier PageParts contient les variables qui sont utilisées dans les pages du site, ce sont ces variables que vous pouvez modifier pour l'utiliser sur votre machine.

Nous vous conseillons de regarder sur le GitHub (https://github.com/Seluj/WE4A-Project) avant de regarder le code ou d'essayer de l'héberger sur votre machine.
Vous y trouverez des informations sur les liens du site et de la base de données.

Pierre et Jules


Version PHP : 8.0.23
Version MariaDB (ou MySQL) : 10.3.32

Un seul fichier de configuration doit etre modifié pour que le site fonctionne sur votre machine : config.php
'host' => 'votre adresse IP ou localhost',
'username' => 'nom d'utilisateur de la base de données (root par défaut)',
'password' => "Mot de passe de la base de données (rien ou root par défaut)",
'dbname' => 'Nom de la base de données',

Pour créer la base de données, vous pouvez utiliser le fichier WE4A.sql qui se trouve ZIP.

Un fichier variables.php se trouve dans le dossier PageParts.
Il contient les variables qui sont utilisées dans les pages du site, ce fichier n'a pas besoin d'etre modifier, car les liens fonctionnent.
Toute fois, si vous voulez modifier les liens, vous pouvez le faire dans ce fichier, mais il faudra soit supprimer les données de la base de données, soit récupérer les fichiers et les mettre dans les dossiers correspondants.