<?php
    function search(){
        echo "<html lang=\"fr\"> 
        <head>
        <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>InstaPets</title> 
        </head>
        <body>
        <form method=\"get\">
       <label for="recherche">Rechercher un utilisateur:</label><input type=\"search\" name=\"q\" placeholder=\"saisir un pseudo\">
        <input type =\"submit\" name=envoyer>
        </form>
        <section class=\"afficher utilisateur\">";
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `users` ORDER BY id DESC');
		$stmt->execute();
		$utilisateurs = $stmt->fetchAll();
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $recherche = htmlspecialchars($_GET['q']);
            $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `users` WHERE user_pseudo LIKE "%'.$recherche.'%" ORDER BY id DESC'); 
            $stmt->execute();
		    $utilisateurs = $stmt->fetchAll();

        }
        if($utilisateurs->rowCount() > 0){
            while($user = $utilisateurs->fetchAll()){
            echo "<li><a href=\"index.php?action=profil&id=" .$user['user_id']."\" >".$user['user_pseudo']."</a>";
	    }
        } else{
           echo "<p> Aucun utilisateur trouvé</p>";
        }
        echo "</section>
        </body>
        </html>";
    } // remplacer par $ html et return $html ???? voir deja si comme ça ça marche bien
?>
