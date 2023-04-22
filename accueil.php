<?php
    function display_Acceuil(){
       $html =  "<html lang=\"fr\"> 
        <head>
        <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>InstaPets</title> 
        <link href=\"accueil.css\" rel=\"stylesheet\">
        </head>
        <body>
	<header>
	<h1>InstaPets</h1>
	</header>";
	
        if(!isset($loggedUser)){
            // presentation du site a jouter ¿fonction readme d'un readme.php?
            $html .= "<li><a href=\"index.php?action=inscription\">Rejoignez-nous!</a></li><li><a href=\"index.php?action=connexion\">J'ai déjà un compte!</a></li>";
        }
	else{
		$html .="<h2>Publications Récentes</h2>";
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

    $html .="</body></html>";
 
    return $html;
    }
?>
