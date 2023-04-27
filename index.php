<?php session_start();
include_once('inscription.php');
include_once('bienvenue.php');
include_once('traitementInscription.php');
include_once('connexion.php');
include_once('traitementConnexion.php');
if(!isset($_SESSION['LOGGED_MDP']){
    if(isset($_GET['action']){
        switch($_GET['action']){
            case 'bienvenue' :
                echo display_Bienvenue();
                break;
            case 'inscription' :
                echo print_form(false);
                break;
            case 'sauvergarder' :
                if(inscriptionValidee()){
                    echo felicitations(false);
                    break;
                }else{
                    echo print_form(false);
                    }
            case 'connexion' :
                echo print_Login();
                break;
            case 'check' :
                if(connexion_check()){
                    echo display_Accueil();
                    break;
                }else {
                    echo print_Login();
                    break;
                }
            default : header('Location: index.php?action=bienvenue');
        }
    }else{
        echo display_Bienvenue();
    }
    
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profil utilisateur</title>
</head>
<body>
<h1> Insta Pets</h1>
<?php

include_once('accueil.php');
include_once('felicitations.php');
include_once('publier.php');
include_once('recherche.php');
include_once('profil.php');
include_once('abonnerment.php');

 
if(!isset ($_GET['action'])){
    echo display_Accueil(); // si le script arrive ici c'est que l'user est connecté
}else{
    switch($_GET['action']){
        case 'modifier' :
            echo print_form(true); // a ameliorer (preremplissage des champs sauf mdp pr plus de sécurité?)
            break;
        case 'update' :
            if(modificationValidee()){ //À CREER
                echo felicitations(true);
                break;
            } else{
                echo print_form(true);
            }
	    case 'publier' :
            publier() ; // je dois revenir dessus
            break;
	    case 'search' :
            search(); // je dois revenir dessus
            break;
        case 'profil' :
	        $id=$_GET['id'];
            echo display_profil($id);
            break;
        case 'unfollow':
            $id=$_GET['id'];
            unFollow($id);
            echo display_profil($id);
            break;
        case 'subscribe':
            $id=$_GET['id'];
            follow($id);
            echo display_profil($id);
            break;
       
        default :
          echo display_Accueil();  
    }
}
?>
<footer>
		<p>&copy; 2023 InstaPets</p>
        <p>KACI Amel & PERRIER-BABIN Ludivine</p>
</footer>
</body>
</html>

