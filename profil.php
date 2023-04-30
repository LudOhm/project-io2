<?php 
 include_once('traitementLikes.php');

  function count_Followers($id){
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $followers = $pdo->prepare('SELECT count(*) FROM Followers WHERE user_id = ?');
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
    return ($num > 0);
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
    $result = $Recup->fetch();
    $isAdmin = $result ? $result['user_admin'] : false;

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

    $html.="<p>".count_Followers($id)." abonné(s)</p>";

    // afficher les posts du profil
		$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_contenu, Posts.post_picture, Posts.post_id, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id WHERE Users.user_id = ? ORDER BY Posts.post_id DESC LIMIT 20');
    $stmt->execute([$id]);
    $posts = $stmt->fetchAll();
    foreach ($posts as $post) {
        $html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" ;
        $html .= "<img src=\"data:image/jpeg;base64," . base64_encode($post['post_picture']); "\" alt=\"Post Picture\">";
        $html .= "<br>" . htmlspecialchars($post['post_contenu']) . "</p><p class=\"meta\">Posted by <a href=\"index.php?action=profil&amp;id=".$id."\">" . htmlspecialchars($post['user_pseudo'])."</a></p></article>";
      
        if($isAdmin){
          			$html.="<button type=\"button\"><a href=\"index.php?action=delete&amp;id=".$post['post_id']."\">Supprimer la publication</a></button>"; 
        		} 
		}
	// en dessous je vais m'occuper d'un peu réorganiser tout ça je fais une petite pause
	  $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"get\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<input type=\"submit\" value=\"Ok !\"></form> 
        	<ul>
          <li><a href=\"index.php?action=accueil\">Accueil</a></li>
        	<li><a href=\"index.php?action=publier\">Publier</a></li>
        	<li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
        	</ul>
       		</aside>";
        if($id != $_SESSION['LOGGED_ID']){
            if(is_Logged_User_Subscribed($id)){
              $html .= "<li><a href=\"index.php?action=unfollow&amp;id=;".$id."\">Se désabonner</a></li>";
            }else{
              $html .= "<li><a href=\"index.php?action=subscribe&amp;id=;".$id."\">Suivre</a></li>";
            }
        }else{
          $html .=  "<li><a href=\"index.php?action=publier\">Ajouter une nouvelle publication></a></li>
          <li><a href=\"index.php?action=modifier\">Modifier mes infos></a></li>";
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
    

    
    
