<?php
    function display_Accueil(){
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
        if(!isset($_SESSION['LOGGED_USER'])||!isset($_COOKIE['LOGGED_USER'])){ 
            $html .= " <h2>Bienvenue sur Instapets, le réseau social pour les détenteurs d'animaux qui veulent partager 
            et communiquer avec les autres détenteurs d'animaux qui partagent un intérêt commun.</h2><br>
            <li><a href=\"index.php?action=inscription\">Rejoignez-nous!</a></li><li><a href=\"index.php?action=connexion\">J'ai déjà un compte!</a></li>";
        }
        
		else{
			$user_id = $_COOKIE['LOGGED_USER'];
            $html.="<h2>Recent Posts</h2>";
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
		    $stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id ORDER BY DESC LIMIT 20');
		    $stmt->execute();
		    $posts = $stmt->fetchAll();
			foreach ($posts as $post) {
				$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
                "</p><p class=\"meta\">Posted by" . htmlspecialchars($post['user_id'])."</p></article>";
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
