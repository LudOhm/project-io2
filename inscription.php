<?php
function print_form($modifier) {
  $mot = $modifier ? "Modifier mes informations" : "S'inscrire";
  $destination = $modifier ? "update" : "sauvegarder";
  //$valDate = strlen($date) > 0 ? '$date' : 'jj/mm/aaaa';
  // AJOUT PHOTO DE PROFIL ????

  $html =
    "<html>
    <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Inscription</title>
    <link rel=\"stylesheet\" href=\"inscription.css\">
    </head>
    <body>
    <h2>$mot</h2>
    <main>
    <form action='index.php?action=$destination' method='post'>
    <label for=\"pseudo\">Pseudo :</label>
    <input type=\"text\" id=\"pseudo\" placeholder=\"pseudo\" required=\"required\" name=\"Pseudo\">
    <br>
    <label for=\"nom\">Nom :</label>
    <input type=\"text\" id=\"nom\" placeholder=\"nom\" required=\"required\" name=\"nom\">
    <br>
    <label for=\"prenom\">Prenom :</label>
    <input type=\"text\" id=\"prenom\" placeholder=\"prenom\" required=\"required\" name=\"prenom\">
    <br>
    <br>
    <label for=\"date\">Date de naissance :</label>
    <input type=\"date\" id=\"date\" required=\"required\" name=\"date\">
    <br>
    <label for=\"mail\">Adresse mail : </label>
    <input type=\"email\" id =\"mail\" name=\"mail\" required=\"required\" pattern=\"^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}\">
    <br>
    <label for=\"mdp\">Mot de passe : </label>
    <input type=\"password\" name=\"mdp\" placeholder=\"mot de passe\">
    <br>
    <input type=\"submit\" value=\"$mot\">
    </form>
    </main>
    </body>
    </html>";
  return $html;
}
?>
