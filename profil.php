<?php if(!isset($loggedUser)){ header("Location : index.php?action=inscription");} ?>
<?php

include('subscribe.php'); // dans ce fichier on gere abonnement et desabonnement
      function display_Profil($id){
       $html =  "<html lang=\"fr\"> 
        <head>
        <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>InstaPets</title> 
        <link href=\"profil.css\" rel=\"stylesheet\">
        </head>
        <body>
        <h2>Publications</h2>";

        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        $user_id = $_COOKIE['LOGGED_USER'];
        // afficher nombre d'abonnes et abonnement corespondants à $id EN PARAMETRES DE LA FONCTION
		$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = ? ORDER BY DESC LIMIT 20');
		$stmt->execute($user_id);
		$posts = $stmt->fetchAll();
		foreach ($posts as $post) {
				$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
                		"</p><p class=\"meta\">Posted by" . htmlspecialchars($post['user_pseudo'])."</p></article>";
				}
	
	    	$html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<input type=\"submit\" value=\"Ok !\"></form>
        	<ul>
        	<li><a href=\"index.php?action=publier\">Publier</a></li>
        	<li><a href=\"index.php?action=profil\">MonCompte</a></li>
        	</ul>
       		</aside>";
        if($id != $user_id){
            /*afficher le bouton s'abonner / désabonner 
                appel a une fonction subscribe.php;
            */
            
        }else{
            /* on est sur le profil de l'user courant
            <li><a href=index.php?action=publier>Ajouter une nouvelle publication>
            */ 
        }

    $html .="</body></html>";
 
    return $html;
    }
    ?>
    

    
    
