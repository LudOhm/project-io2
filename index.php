<?php
    session_start();
    include_once('inscription.php');
    include_once('bienvenue.php');
    include_once('traitementInscription.php');
    include_once('connexion.php');
    include_once('traitementConnexion.php');
    include_once('felicitations.php');
   if(!isset($_SESSION['LOGGED_MDP'])){
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'bienvenue' :
                    $fonction = display_Bienvenue();
                    break;
                case 'inscription' :
                    $fonction = print_form(false);
                    break;
                case 'connexion' :
                    $fonction = print_Login();
                    break;
                case 'sauvegarder' :
                    if(inscriptionValidee()){
                        $fonction =felicitations(false);
                        break;
                    }else{
                        $fonction = print_form(false);
                        break;
                        }
               case 'check' :
                    if(connexion_check()){
                        $fonction = display_Accueil();
                        break;
                    }else {
                        $fonction = print_Login();
                        break;
                    }
                default : $fonction = display_Bienvenue();
            }
        }else{
            $fonction = display_Bienvenue();
        }
   } else {
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'inscriptionValidee' :
                $fonction =felicitations(false);
                break;
            default : $fonction = "EN CONSTRUCTION";
        }
    }else{
        $fonction = "EN CONSTRUCTION";
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
<main><?php echo $fonction?></main>
<footer>
		<p>&copy; 2023 InstaPets</p>
        <p>KACI Amel & PERRIER-BABIN Ludivine</p>
</footer>
</body>
</html>