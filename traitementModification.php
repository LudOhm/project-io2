<?php
/*cas de la modification des infos: recuperer l'utilisateur, valider ses nouvelles infos mais faire attention à la verification des infos*/
function modificationValidee(){
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
//d'abord extraire les informations de l'utilisateur connecté
    $infosLogged = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
    $infosLogged = $infosLogged->execute(array($_SESSION['']))

// recuperer les données du formulaire ->htmlspecialchars ; sha1(); comparer avec données précedentes utiliser des arrays?

// si nouveau pseudo/mail verifier qu'il n'est pas dans la base de données

// Modifier les infos dans la base;
}
?>
