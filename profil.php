<?php 
 include_once('traitementLikes.php');
 include_once('accueil.php');

  function count_Followers($id){
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $followers = $pdo->prepare('SELECT count(*) FROM Followers WHERE user_id = ?');
    $followers->execute(array($id));
    $num = $followers->fetchColumn();
    return (string) $num;
}

function count_Followings($id){
  $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
  $followers = $pdo->prepare('SELECT count(*) FROM Followings WHERE user_id = ?');
  $followers->execute(array($id));
  $num = $followers->fetchColumn();
  return (string) $num;
}



  function is_Logged_User_Subscribed($id){
    // si la fonction est appelée c que id != userLoggedID donc pas besoin de revérifier
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $followers = $pdo->prepare('SELECT count(*) FROM Followings WHERE following_id = ? AND user_id = ?');
    $followers->execute(array($id, $_SESSION['LOGGED_ID']));
    $num = $followers->fetchColumn();
    return ($num > 0 );
  }
  
  function display_Profil($id){

    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    // on recupere l'utilisateur en parametres
    $Recup = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
    $Recup->execute(array($id));
    // on vérifie que l'id correspond bien à un utilisateur
    if($Recup->rowCount()==0){$erreur ="<h1>page non trouvée</h1><a href=\"index.php\">Retour à l'accueil</a>"; return $erreur;} 
    $pseudo_profil = $Recup->fetch()['user_pseudo'];


    //pour test admin car sinon les false ne passent pas dans un fetch tout court
    $adm = $pdo->prepare('SELECT user_admin FROM Users WHERE user_id = ?');
    $adm->execute(array($id));
    $result = $adm->fetch();
    $isAdmin = $result !== false ? $result['user_admin'] : false;


    // ... peut etre recuperer d'autres infos selon nos preferences a voir +tard
    $affichageH2 ="&commat;"; //'@'
    if($id != $_SESSION['LOGGED_ID']){
	$affichageH2 .= $pseudo_profil;
	if($isAdmin) {$affichageH2.=" &#9733;"; }// petie étoile de certification ;)
    } else{
      	$affichageH2 .= "Moi";
	if($isAdmin){$affichageH2.=" &#9733;"; }
    }
 
    $html = "
    <h2>".$affichageH2."</h2><h3>Publications</h3><main>";

        
    // afficher nombre d'abonnes et abonnement corespondants à $id EN PARAMETRES DE LA FONCTION
    // <ul>
		// <li><a href=\"index.php?action=LikedBy\"> $mot </a></li>
    //     	<li><a href=\"index.php?action=abonne\">abonné(s)</a></li>
    //     	<li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
    // </ul>

    if($id == $_SESSION['LOGGED_ID']){
      $nbFollowers = count_Followers($id) . " abonné(s)";
      $html.= "<p><a href=\"index.php?action=abonne&amp;id=".$id."\">$nbFollowers</a> &emsp;";
      $nbFollowings = count_Followings($id)." abonnement(s)</p>";
      $html .= "<a href=\"index.php?action=abonnement&amp;id=".$id."\">$nbFollowings</a></p>";
    }else {
      $html.="<p>".count_Followers($id)." abonné(s) &emsp;";
      $html.=count_Followings($id)." abonnement(s)</p>";
    }

    // afficher les posts du profil
		$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_contenu, Posts.post_picture, Posts.post_id, Users.user_pseudo, Users.user_id FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id WHERE Users.user_id = ? ORDER BY Posts.post_id DESC LIMIT 20');
    		$stmt->execute([$id]);
    		$posts = $stmt->fetchAll();
        if(empty($posts)&& $id == $_SESSION['LOGGED_ID']){
          $html .= "<p>il n'y a aucun poste à afficher pour le moment ! poste quelque chose ! </p>";
        } else if(empty($posts)){
          $html .= "<p>il n'y a aucun poste à afficher pour le moment ! </p>";
        }
		    foreach ($posts as $post) {
        		$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" ;
            if($post['post_picture']!== null){
        		  $html .= "<img src=\"data:image/jpeg;base64," . base64_encode($post['post_picture']). "\" alt=\"Post Picture\" ><br></p><p>";
            }
        		$html .=  htmlspecialchars($post['post_contenu']) . "</p><p class=\"meta\">Posted by <a href=\"index.php?action=profil&amp;id=".$id."\">" . htmlspecialchars($post['user_pseudo'])."</a></p></article>";
            $mot = countPostLikes($post['post_id']) > 1 ? " likes" : " like";

            //si c'est notre compte on peut voir les gens qui ont like les posts
            if($id == $_SESSION['LOGGED_ID']){
              $motfin = countPostLikes($post['post_id']) . $mot;
              $html.= "<a href=\"index.php?action=LikedBy&amp;id=".$post['post_id']."\">$motfin </a>" ;
            }else {
              $html.= countPostLikes($post['post_id']) . $mot;
            }

            if(isPostLiked($post['post_id'], $_SESSION['LOGGED_ID'])){
              $html .= "<form method=\"post\">
              <button type=\"submit\" name=\"unlike{$post['post_id']}\"><i id=\"unlike\" class=\"fa-solid fa-heart\" style=\"color: #e32400;\"></i></button>
              </form>";
              if(isset($_POST['unlike' . $post['post_id']])){
                likePost($post['post_id'], $_SESSION['LOGGED_ID']);
              }


            }else{
              $html .= "<form method=\"post\">
              <button type=\"submit\" name=\"like{$post['post_id']}\"><i id=\"like\" class=\"fa-regular fa-heart\" style=\"color: #e32400;\"></i>Double click to Like !</button>
              </form>";
              if(isset($_POST['like' . $post['post_id']])){
                likePost($post['post_id'], $_SESSION['LOGGED_ID']);
              }

            }
                    if(isAdmin($_SESSION['LOGGED_ID']) || $id == $_SESSION['LOGGED_ID']){
              $html.="<button type=\"button\"><a href=\"index.php?action=delete&amp;id=".$post['post_id']."\">Supprimer la publication</a></button>"; 
            } 
		}
	// en dessous je vais m'occuper d'un peu réorganiser tout ça je fais une petite pause
	  $html .= "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<input type=\"submit\" value=\"Ok !\"></form> 
        	<ul>
		<li><a href=\"index.php?action=accueil\">Accueil</a></li>
        	<li><a href=\"index.php?action=publier\">Publier</a></li>
        	<li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>";
        if($id != $_SESSION['LOGGED_ID']){
            if(is_Logged_User_Subscribed($id)){
              $html .= "<li><a href=\"index.php?action=unfollow&amp;id=".$id."\">Se désabonner</a></li></ul>
              </aside>";
            }else{
              $html .= "<li><a href=\"index.php?action=subscribe&amp;id=".$id."\">Suivre</a></li></ul>
              </aside>";
            }
        }else{
          $html .=  "<li><a href=\"index.php?action=modifier\">Modifier mes infos></a></li>
          <li><a href=\"index.php?action=deconnexion\">Se déconecter></a></li></ul>
          </aside>";
        }

    return $html;
    }

    function follow($id){
        if(isset($_SESSION['LOGGED_MDP']) && isset($_SESSION['LOGGED_PSEUDO'])) {
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
      
        // verifie que le user a follow existe (je pense pas que c'est obligatoire mais bon)
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
            $stmt->execute([$id]);
            $user = $stmt->fetch();
      
            if(!$user) {
                echo "l' user n'existe pas.";
                return;
            }
      
        // si il est deja suivi
            $stmt = $pdo->prepare('SELECT * FROM Followings WHERE user_id = ? AND following_id = ?');
            $stmt->execute([$_SESSION['LOGGED_ID'], $id]);
            $followed = $stmt->fetch();
      
            if($followed) {
            //il va donc l'unfollow
                return unFollow($id);
            } 
            else{
      
                // sinon il va le follow
                $pdo->beginTransaction();
      
                $stmt = $pdo->prepare('INSERT INTO Followings (user_id, following_id) VALUES (?, ?)');
                $stmt->execute([$_SESSION['LOGGED_ID'], $id]);
      
                $stmt = $pdo->prepare('INSERT INTO Followers (user_id, followers_id) VALUES (?, ?)');
                $stmt->execute([$id, $_SESSION['LOGGED_ID']]);
      
                $pdo->commit();
      
                return;
            }
        }
    }

    function getUsersWhoFollow($user) {
      $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
      $stmt = $pdo->prepare('SELECT Users.user_pseudo, Users.user_id 
                   FROM Followers 
                   JOIN Users ON Followers.followers_id = Users.user_id 
                   WHERE Followers.user_id = ? 
                   ORDER BY Users.user_id DESC');
      $stmt->execute(array($user));
      $users = $stmt->fetchAll();
      
      $html = "<h2>Les personnes qui te suive</h2>";
      if(count($users) > 0) {
        foreach($users as $user) {
          $html .= "<li><a href=\"index.php?action=profil&amp;id=" .$user['user_id']."\">" . $user['user_pseudo'] . "</a></li>";
        }
      } else {
        $html .= "<p>Aucune personne ne te suis</p>";
      }
      $html .= "<a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">Retour sur mon profil</a>";
      
      return $html;
    }

    function getUsersWhoFollowed($user) {
      $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
      $stmt = $pdo->prepare('SELECT Users.user_pseudo, Users.user_id 
                             FROM Followings 
                             JOIN Users ON Followings.following_id = Users.user_id 
                             WHERE Followings.user_id = ? 
                             ORDER BY Users.user_id DESC');
      $stmt->execute(array($user));
      $users = $stmt->fetchAll();
      
      $html = "<h2>Les personnes que tu suis :</h2>";
      if(count($users) > 0) {
          foreach($users as $user) {
              $html .= "<li><a href=\"index.php?action=profil&amp;id=" .$user['user_id']."\">" . $user['user_pseudo'] . "</a></li>";
          }
      } else {
          $html .= "<p>Tu ne suis personne pour le moment</p>";
      }
      $html .= "<a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">Retour sur mon profil</a>";
      
      return $html;
  }
  
      

    function unFollow($id){
       if(isset($_SESSION['LOGGED_MDP']) && isset($_SESSION['LOGGED_PSEUDO'])){
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    
            $stmt = $pdo->prepare("DELETE FROM Followings WHERE user_id = :logged_id AND following_id = :id");
            $stmt->execute(array(':logged_id' => $_SESSION['LOGGED_ID'], ':id' => $id));
    
            $stmt = $pdo->prepare("DELETE FROM Followers WHERE user_id = :id AND followers_id = :logged_id");
            $stmt->execute(array(':logged_id' => $_SESSION['LOGGED_ID'], ':id' => $id));
       }
    }
    

?>
    

    
    
