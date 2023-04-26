<?php session_start() 
if(!isset($_SESSION['LOGGED_MDP'])){
    header('Location: index.php?action=bienvenue');
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

include('accueil.php');
include('inscription.php');
include('bienvenue.php');
include('traitementInscription.php');
include('connexion.php');
include('traitementConnexion.php');
include('felicitations.php');
include('publier.php');
include_once('recherche.php');
include_once('profil.php');
include_once('abonnerment.php');

 
if(!isset ($_REQUEST['action'])){
    echo display_Accueil(); // si le script arrive ici c'est que l'user est connecté
}else{
    switch($_REQUEST['action']){
        case 'inscription' :
            echo print_form(false);
            break;
        case 'modifier' :
            echo print_form(true); // a ameliorer (preremplissage des champs sauf mdp pr plus de sécurité?)
            break;
        case 'update' :
            if(modificationValidee()){ //À CREER
                echo felicitations(true);
                break;
            } else{
                header('Location: index.php?action=modifer');
            }
       case 'sauvergarder' :
            if(inscriptionValidee()){
                echo felicitations(false);
                break;
            }else{
                header('Location: index.php?action=inscription');
            }
        case 'connexion' :
            echo print_Login();
            break;
        case 'check' :
            if(connexion_check()){
                echo display_Accueil();
                break;
            }
            else {
                echo print_Login();
                break;
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
        case 'bienvenue' :
            echo display_Bienvenue();

       
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

