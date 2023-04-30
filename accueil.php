<?php

include_once('traitementLikes.php');
	
	function isAdmin($usertoCheck){
		//pour savoir si admin
		$pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root'); //il faut appeler la base avant
		$stm = $pdo->prepare('SELECT user_id, user_admin FROM Users WHERE user_id = ?');
		$stm->execute(array($usertoCheck));
		$isadmin = $stm->fetch()['user_admin'] ;
		return $isadmin;
	}
    function display_Accueil(){
	
       $html =  "<main>";
       
        
	$loggedUser = $_SESSION['LOGGED_ID'];
        $html.="<h2>Recent Posts</h2>";
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
		//pour avoir les posts
		$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_contenu, Posts.post_picture, Posts.post_id, Users.user_pseudo, Users.user_id FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id ORDER BY Posts.post_id DESC LIMIT 20');
		$stmt->execute();
		$posts = $stmt->fetchAll();
		foreach ($posts as $post) {
			$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" ;
			$html .= "<img src=\"data:image/jpeg;base64," . base64_encode($post['post_picture']) "\" alt=\"Post Picture\">";
			$html .= "<br>" . htmlspecialchars($post['post_contenu']) . "</p><p class=\"meta\">Posted by <a href=\"index.php?action=profil&amp;id=".$post['user_id']."\">" . htmlspecialchars($post['user_pseudo'])."</a></p></article>";
			
			if((isAdmin($_SESSION['LOGGED_ID']))||($_SESSION['LOGGED_ID']==$post['user_id'])) {
				$html .= "<button type=\"button\"><a href=\"index.php?action=delete&amp;id=".$post['post_id']."\">Supprimer la publication</a></button>"; 
				}
	
		}
	
	    $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
        <input type=\"submit\" value=\"Ok !\"></form>
        <ul>
	<li><a href=\"index.php?action=accueil\">Accueil</a></li>
      <li><a href=\"index.php?action=publier\">Publier</a></li>
      <li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
        </ul>
        </aside>";
 
        return $html;
    }
?>
