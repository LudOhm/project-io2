<?php
function print_form($modifier) {
  $mot = $modifier ? "Modifier mes informations" : "S'inscrire";
  $destination = $modifier ? "update" : "sauvegarder";
  //$valDate = strlen($date) > 0 ? '$date' : 'jj/mm/aaaa';
  // AJOUT PHOTO DE PROFIL ???? vrmnt si on a le temps

  $html =
    "<h2>$mot</h2>
    
    <form action='index.php?action=$destination' method='post'>
    <label for=\"pseudo\">Pseudo :</label>
    <input type=\"text\" id=\"pseudo\"  required=\"required\" name=\"Pseudo\" ";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_PSEUDO']."\">";
    }else{
     $html .= "placeholder=\"Votre pseudo\">";
    }
    $html.= "<br>
    <label for=\"nom\">Nom :</label>
    <input type=\"text\" id=\"nom\" required=\"required\" name=\"nom\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_NOM']."\">";
    }else{
     $html .= "placeholder=\"Votre nom\">";
    }
    $html.= "<br>
    <label for=\"prenom\">Prenom :</label>
    <input type=\"text\" id=\"prenom\"  required=\"required\" name=\"prenom\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_PRENOM']."\">";
    }else{
     $html .= "placeholder=\"Votre prénom\">";
    }
    $html.="<br>
    <label for=\"date\">Date de naissance :</label>
    <input type=\"date\" id=\"date\" required=\"required\" name=\"date\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_DATE']."\">";
    } else{
      $html .= ">";
    }
    $html .="<br>
    <label for=\"mail\">Adresse mail : </label>
    <input type=\"email\" id =\"mail\" name=\"mail\" required=\"required\" pattern=\"^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_MAIL']."\">";
    }else{
     $html .= "placeholder=\"ex: toto@mail.com\">";
    }
    $html.="<br>
    <label for=\"mdp\">Mot de passe : </label>
    <input type=\"password\" name=\"mdp\" placeholder=\"mot de passe\">
    <br>
    <input type=\"submit\" value=\"$mot\">
    </form>";
  return $html;
}
?>
