<?php
    session_start();
    include_once('inscription.php');
    include_once('bienvenue.php');
    include_once('connexion.php');
    include_once('felicitations.php');
    include_once('accueil.php');
    include_once('profil.php');
    include_once('publier.php');
    include_once('recherche.php');
	
     $title = "InstaPets"; //par defaut on sait jamais
     $style = "defaut.css"; //a creer

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
                    		 	$title = "Inscription";
                    			$style = "inscription.css";
                   			 break;
                		}
            		case 'profil' :
				$id = $_GET['id'];
                		$fonction = display_Profil($id);
                		$style = "profil.css";
                		$title = "Profil utilisateur";
                		break;
            		case 'publier' :
               			$fonction = publier();
                		$style = "publier.css"; // a creer
                		$title = "Nouvelle publication";
                		break;
			
			case 'search':
				$user = htmlspecialchars($_POST['q']);
				$fonction = search($user);
				$style = "recherche.css";
				$title = "Rechercher un utilisateur";
				break;
				
			case 'subscribe':
				$id=$_GET['id'];
				follow($id);
				$fonction = display_Profil($id);
				$style = "profil.css";
                		$title = "Profil utilisateur";
				break;
			
			case 'unfollow':
				$id=$_GET['id'];
				unFollow($id);
				$fonction = display_Profil($id);
				$style = "profil.css";
                		$title = "Profil utilisateur";
				break;
			case 'delete':
				$id=$_GET['id'];
				delet($id);
				$fonction = display_Accueil(); 
				$title = "Mon fil d'actualité"; 
				$style = "accueil.css";
				break;
            case 'LikedBy':
                $id = $_GET['id'];
                $fonction = getUsersWhoLikedPost($id);
                $title = "aimé par"; 
				$style = "likedBy.css";
                break;
	
            	default : $fonction = display_Accueil(); $title = "Mon fil d'actualité"; $style = "accueil.css";
       		}
    	}else{
        	$fonction = display_Accueil();$title = "Mon fil d'actualité"; $style = "accueil.css";
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
<?php echo $fonction?>
<footer>
		<p>&copy; 2023 InstaPets</p>
        <p>KACI Amel & PERRIER-BABIN Ludivine</p>
</footer>
</body>
</html>
