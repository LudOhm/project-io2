<?php
    session_start();
    include_once('inscription.php');
    include_once('bienvenue.php');
    include_once('traitementInscription.php');
    include_once('connexion.php');
    include_once('traitementConnexion.php');
    include_once('felicitations.php');
    include_once('traitementModification.php');
    include_once('accueil.php');
    include_once('profil.php');
   if(!isset($_SESSION['LOGGED_MDP'])){
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'bienvenue' :
                    $fonction = display_Bienvenue();
                    $title = "Bienvenue sur InstaPets";
                    $style = "bienvenue.css";
                    break;
                case 'inscription' :
                    $fonction = print_form(false);
                    $title = "Inscription";
                    $style = "inscription.css";
                    break;
                case 'connexion' :
                    $fonction = print_Login();
                    $title = "Connexion";
                    $style = "connexion.css";
                    break;
                case 'sauvegarder' :
                    if(inscriptionValidee()){
                        $fonction =felicitations(false);
                        $style = "felicitations.css";
                        $title = "Inscription Réussie";
                        break;
                    }else{
                        $fonction = print_form(false);
                        $title = "Inscription";
                        $style = "inscription.css";
                        break;
                        }
               case 'check' :
                    if(connexion_check()){
                        $fonction = display_Accueil();
                        $title = "Mon fil d'actualité";
                        $style = "accueil.css";
                        break;
                    }else {
                        $fonction = print_Login();
                        $title = "Connexion";
                        $style = "connexion.css";
                        break;
                    }
                default : $fonction = display_Bienvenue();$title = "Bienvenue sur InstaPets";$style = "bienvenue.css";
            }
        }else{
            $fonction = display_Bienvenue();
            $title = "Bienvenue sur InstaPets";
            $style = "bienvenue.css";
        }
   } else {
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'modifier' :
                $fonction = print_form(true);
                $title = "Modification des informations";
                $style = "inscription.css";
                break;
            case 'update' :
                if(modificationValidee()){
                    $fonction =felicitations(true);
                    $style = "felicitations.css";
                    $title = "Modifications des informations enregistrée";
                    break;
                }else{
                    $fonction = print_form(true);
                    $style = "inscription.css";
                    break;
                }
            case 'profil' :
                    $fonction = display_profil($_SESSION['LOGGED_ID']);
                    $style = "profil.css";
                    $title = "Votre profil";
                    break;
            default : $fonction = $fonction = display_Accueil(); $title = "Mon fil d'actualité"; $style = "accueil.css";
        }
    }else{
        $fonction = "EN CONSTRUCTION";
    }
   }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php  echo $title ?></title>
<script src="https://kit.fontawesome.com/b1ff4425a2.js" crossorigin="anonymous"></script>
<link href="<?php echo $style?>" rel="stylesheet">
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