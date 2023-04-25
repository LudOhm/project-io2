<?php session_start() ?>
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

include('traitementInscription.php');
include('connexion.php');
include('traitementConnexion.php');
include('felicitations.php');
include('publier.php');
//include_once('recherche.php');
//include_once('profil.php')

 
if(!isset ($_REQUEST['action'])){
    echo display_Accueil();
}else{
    switch($_REQUEST['action']){
        case 'inscription' :
            echo print_form(false);
            break;
        case 'modifier' :
            echo print_form(true); // a ameliorer (preremplissage des champs sauf mdp pr plus de sécurité?)
            break;
       case 'sauvergarder' :
            if(inscriptionValidee()){
                echo felicitations(false);
                break;
            }else{
                echo print_form(false);
                break;
            }
        case 'connexion' :
            echo print_Login();
            break;
        case 'check' :
            if(connexion_check()){
                echo display_Accueil(); // ou bien profil??
                break;
            }
            else {
                echo print_Login();
                break;
            }
	case 'publier' :
            publier() ;
            break;
	 case 'search' :
            search();
            break;
        case 'profil' :
	    
            echo display_profil($id);
            break;

         /*case 'update' :
            //creer un fichier update.php

            break;
        
        case 'search' :
            break;
        case 'profil' :
            // la cv etre technique je sens
            break;*/
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

