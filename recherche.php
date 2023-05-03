<?php
    function search($user){
    

        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
		//$stmt = $pdo->prepare('SELECT user_pseudo, user_id FROM `Users` ORDER BY user_id DESC'); 
		if(isset($user)&&!empty($user)){
			$stmt = $pdo->prepare('SELECT user_pseudo, user_id 
						FROM `Users` 
						WHERE user_pseudo 
						LIKE ? 
						ORDER BY user_id DESC'); 
			$stmt->execute(array('%' . $user . '%'));
			$utilisateurs = $stmt->fetchAll();
		}
           
	    $html = "<main><h2>Résultat pour '".$user."'</h2>";
       
        if(isset($utilisateurs) && count($utilisateurs) > 0){
            foreach($utilisateurs as $ut){
            	$html.= "<li><a href=\"index.php?action=profil&amp;id=" .$ut['user_id']."\" >".$ut['user_pseudo']."</a></li>";
	   		}
			$html.= "</main><br>
			<aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
			<label for=\"recherche\">Modifier ma recherche :</label><div class=\"valider\"><button type=\"submit\" >Ok !</button></div>
			</form><div class=\"retour\"><a href = \"index.php\">Retour à l'accueil</a></div></aside>";
        } else{
           $html.= "<h3> Aucun utilisateur trouvé</h3></main>
			<aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
			<label for=\"recherche\">Modifier ma recherche :</label><div class=\"valider\"><button type=\"submit\">Ok !</button></div>
			</form><div class=\"retour\"><a href = \"index.php\">Retour à l'accueil</a></div></aside>";
        }
       return $html;
    }
?>
