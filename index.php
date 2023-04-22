<?php session_start() ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profil utilisateur</title>
</head>
<body>
<?php
include_once('sauvegarde.php');
include_once('acceuil.php');
include_once('inscription.php');
include_once('traitementConnexion.php');
include_once('traitementInscription.php');
include_once('publier.php');
include_once('recherche.php');
include_once('profil.php')

if(/* utilisateur connecte*/){
  //attribution variables;
}else {
    $nom=$prenom=$pseudo=$date=$mail='';
}

if(!isset $_REQUEST['action']){
    //display acceuil
}else{
    switch($_REQUEST['action']){
        case 'inscription' :
            echo print_form($nom, $prenom, $pseudo, $date, $mail, false);
            break;
        case 'modifier' :
            echo print_form($nom, $prenom, $pseudo, $date, $mail, true);
            break;
        case 'sauvergarder' :
            //reprendre fichier traitementInscription.php / petit twist : si modification, on préremplit le formulaire ?cas particulier changeMDP??
            break;
        case 'connexion' :
            // traitementConnexion.php
            break;
        case 'publier' :
            // publier.php
            break;
        case 'search' :
            break;
        case 'profil' :
            // la cv etre technique je sens
            break;
        default:
            //acceuil
        
    }


}

?>
<footer>
<p>&copy; 2023 InstaPets</p>
<p>KACI Amel & PERRIER-BABIN Ludivine</p>
</footer>
</body>
</html>
