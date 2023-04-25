faire un site web style réseau social un peu comme instagram pour un projet d'université.

-il faut faire publier qui est l'endroit ou les publication sont mises. --> publier c'est juste une fonction qui ajoute un post à la base
-Sur le profil, tous les posts du profil; Sur Acceuil: seulement les posts des profils auxquels l'utilisateur connecté est abonné

-la page Rechercher aussi.
-le css est a refaire partout.
- ajouter une colonne isAdmin dans la base ???? (Comptes administrateurs : Certains comptes pourront être d ́esignés comme administrateurs. Ces comptes pourront effacer les publications de tous les autres utilisateurs.) ELLE EST LA MA CERTIFICATION !!!
- affichage dans index.php seulement, je m'occupe de remettre les pages en fonctions php (page inscription à priori terminée)
-il faudra a un moment qd les cookies seront fait faire des fonction de chiffrage et dechiffrage de mot de passe avant de le mettre dans la base de donnée et en le recupérant pour le comparer
-faire la page follow et unfollow qui seront deux autres fichiers je pense
-pareil pour les likes a rajouter dans publier le lien vers le fichier like je pense


aussi les commande a faire sur terminale dans le fichier du projet pour démarrer la base de donnée avec mamp:
/Applications/MAMP/Library/bin/mysql -u root -p
source /Applications/MAMP/htdocs/project-io2/base.sql

quand il y a un changement dans le fichier de la base il faut la supp et la recréer :
DROP DATABASE instapets;

/!\ LA FONCTION SETCOOKIE IL FAUDRA LA METTRE AU TOUT DEBUT DE INDEX.PHP AVEC LE SESSION START SINON PROBLEME /!\
