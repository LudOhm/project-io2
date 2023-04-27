<?php
	
	function isAdmin($usertoCheck){
		//pour savoir si admin
		$pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root'); //il faut appeler la base avant
		$stm = $pdo->prepare('SELECT user_id, user_admin FROM Users WHERE user_id = ?');
		$stm->execute(array($usertoCheck));
		$isadmin = $stm->fetch()['user_admin'] ;
		return $isadmin;
	}
    function display_Accueil(){
	// include('suppression.php')
		if(!isset($_SESSION['LOGGED_MDP'])&&!isset($_SESSION['LOGGED_PSEUDO'])){ 
		header('Location: index.php?action=bienvenue');
		}
       $html =  "<html lang=\"fr\"> 
        <head>
        <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>InstaPets</title> 
        <link href=\"accueil.css\" rel=\"stylesheet\">
        </head>
        <body>
	    <header>
	    </header>
	    <main>";
       
        
		$loggedUser = $_SESSION['LOGGED_ID'];
        $html.="<h2>Recent Posts</h2>";
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
		//pour avoir les posts
		$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Posts.post_id, Users.user_pseudo, Users.user_id FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id ORDER BY DESC LIMIT 20');
		$stmt->execute();
		$posts = $stmt->fetchAll();
		foreach ($posts as $post) {
			$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
            "</p><p class=\"meta\">Posted by <a href=\"index.php?action=profil&amp;id=".$post['user_id']."\">" . htmlspecialchars($post['user_pseudo'])."</a></p></article>";
				
			//ajout du bouton seulement si admin
			//on peut faire un test si le post appartient au user logged il peut supprimer son post
				if((isAdmin($_SESSION['LOGGED_ID']))||($_SESSION['LOGGED_ID']==$post['user_id'])) {
				$html .= "<a href=\"index.php?action=suppression&amp;id=".$post['post_id']."\">Supprimer la publication</a>"; 
				}
	
			}
	
	    $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
        <input type=\"submit\" value=\"Ok !\"></form>
        <ul>
      <li><a href=\"index.php?action=publier\">Publier</a></li>
      <li><a href=\"index.php?action=profil&ampid=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
        </ul>
        </aside></body></html>";
 
        return $html;
    }
?>
