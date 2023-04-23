<!--
<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>Nom réseau</title> 
    </head>
<body> 
    <header> 
        <h1>Nom réseau</h1>
        
    </header>

    <nav>
    </nav>

    <main>
-->
    <?php
      function display_Profil(){
       $html =  "<html lang=\"fr\"> 
        <head>
        <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>InstaPets</title> 
        <link href=\"profil.css\" rel=\"stylesheet\">
        </head>
        <body>
	<header>
	<h1>InstaPets</h1>
	</header>";
	
    if(!isset($loggedUser)){
            // presentation du site a jouter ¿fonction readme d'un readme.php?
            $html .= "<li><a href=\"index.php?action=inscription\">Rejoignez-nous!</a></li><li><a href=\"index.php?action=connexion\">J'ai déjà un compte!</a></li>";
        }else{
		$html .="<h2>Dernière publication</h2>";
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    //faire une variable avec l'id ou l'email du user logged et le comparer dans le prepare 
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

    </main>
    <!--  sera a mettre dans le $html après 
    <aside>
        <form>
          <input type="submit" value="S'abonner">
        </form>
        <form>
          <input type="search" name="q" placeholder="Rechercher">
          <input type="submit" value="Ok !">
        </form>
        <ul>
          <li><a href="#">Comptes</a></li>
          <li><a href="#">Publier</a></li>
          <li><a href="#">MonCompte</a></li>
        </ul>
      </aside> -->

    
    
</body>
</html>