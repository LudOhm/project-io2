<?php
    function display_Accueil(){
	// include('suppression.php')
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
        if(!isset($_SESSION['LOGGED_MDP'])&&!isset($_SESSION['LOGGED_PSEUDO'])){ 
            header('Location: index.php?action=bienvenue');
        }
        
		else{
			$loggedUser = $_SESSION['LOGGED_ID'];
            $html.="<h2>Recent Posts</h2>";
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
			//pour avoir les posts
		    $stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo, Users.user_id FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id ORDER BY DESC LIMIT 20');
		    $stmt->execute();
		    $posts = $stmt->fetchAll();
			//pour savoir si admin
			$stm = $pdo->prepare('SELECT user_id, user_admin FROM Users WHERE user_id = ?');
			$stm->execute([$loggedUser]);
			$user = $stm->fetch();
			foreach ($posts as $post) {
				$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
                "</p><p class=\"meta\">Posted by" . htmlspecialchars($post['user_pseudo'])."</p></article>";
				
				//ajout du bouton seulement si admin
				//on peut faire un test si le post appartient au user logged il peut supprimer son post
				if($user['user_admin']||($user['user_id']==$post['user_id'])) {
				$html .= "<button onclick=\"confirmDelete()\">Delete Post</button></article><script>
				function confirmDelete() {
					if (confirm(\"Are you sure you want to delete this post?\")) {
						if (confirm(\"This action cannot be undone. Are you sure you want to proceed?\")) {
							// Redirect to the suppression.php page
							window.location.href = \"suppression.php\";
						}
					}
				}
				</script>";
				}
	
			}
	
	    $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
        <input type=\"submit\" value=\"Ok !\"></form>
        <ul>
      <li><a href=\"index.php?action=publier\">Publier</a></li>
      <li><a href=\"index.php?action=profil\">MonCompte</a></li>
        </ul>
        </aside>";
    }

        $html = $html."</body></html>";
 
        return $html;
    }
?>
