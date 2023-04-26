<?php 
  include('suppressionPublication.php');
  include('subscribe.php'); // dans ce fichier on gere abonnement et desabonnement
  
  function display_Profil($id){

    if(!(isset($_SESSION['LOGGED_MDP'] ) && !isset( $_SESSION['LOGGED_PSEUDO']))){ header("Location : index.php?action=bienvenue");}
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    // on recupere l'utilisateur en parametres
    $Recup = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
    $Recup->execute(array($id));
    $pseudo_profil = $Recup->fetch()['user_pseudo'];
    $isAdmin = $Recup->fetch()['user_admin'] ;
    // ... peut etre recuperer d'autres infos selon nos preferences a voir +tard
    $affichageH2 ="&commat;"; //'@'
    if($id != $_SESSION['LOGGED_ID']){
      $affichageH2 .= $pseudo_profil;
    } else{
      $affichageH2 .= "Moi";
    }

    $html = "<html lang=\"fr\"> <head><meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>InstaPets</title><link href=\"profil.css\" rel=\"stylesheet\"></head><body>
    <h2>".$affichageH2."</h2><h3>Publications</h3><main>";

        
    // afficher nombre d'abonnes et abonnement corespondants à $id EN PARAMETRES DE LA FONCTION

    // afficher les posts du profil
		$stmt2 = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = ? ORDER BY DESC LIMIT 20');
		$stmt2->execute($id);
		$posts = $stmt2->fetchAll();
		foreach ($posts as $post) {
				$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
        "</p><p class=\"meta\">Posted by" . htmlspecialchars($post['user_pseudo'])."</p></article>";// verifer si conenu et picture ne sont pas null ???
        if($isAdmin){
          $html.=suppression(); // a créer
        } 
		}
	// en dessous je vais m'occuper d'un peu réorganiser tout ça je fais une petite pause
	  $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<input type=\"submit\" value=\"Ok !\"></form> 
        	<ul>
        	<li><a href=\"index.php?action=publier\">Publier</a></li>
        	<li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
        	</ul>
       		</aside>";
        if($id != $user_id){
            $html .= "<button onclick=\"subscribe.php()\">S'abonner</button>";
            $html .= "<button onclick=\"unfollow.php()\">Se désabonner</button>";
            //je pense qu'il faut faire un test sur ce fichier pour avoir le bouton différent selon si la personne est deja abo ou non
            /*afficher le bouton s'abonner / désabonner 
                appel a une fonction subscribe.php;
                ou unfollow.php?
            */
            
        }else{
          $html .= "<button onclick=\"publier.php()\">Poster</button>";
            /* on est sur le profil de l'user courant
            <li><a href=index.php?action=publier>Ajouter une nouvelle publication>
            */ 
        }

    $html .="</body></html>";
 
    return $html;
    }
    ?>
    

    
    
