<?php
    function search($user){
    
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `Users` ORDER BY id DESC');
		$stmt->execute();
		$utilisateurs = $stmt->fetchAll();
        
           
	    $html = "<h2>Résultat pour '".$user."'</h2>";
            $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `Users` WHERE user_pseudo LIKE ? ORDER BY id DESC'); 
            $stmt->execute(array($user));
	    $utilisateurs = $stmt->fetchAll();

       
        if($utilisateurs->rowCount() > 0){
            	foreach($utilisateurs as $ut){
            		$html.= "<li><a href=\"index.php?action=profil&amp;id=" .$ut['user_id']."\" >".$ut['user_pseudo']."</a>";
	   	 }
		$html.= "
	   <form action=\"index.php?action=search\" method=\"get\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<label for=\"recherche\">Modifier ma recherche :</label><input type=\"submit\" value=\"Ok !\">
	   </form><aside><a href = \"index.php\">Retour à l'accueil</a></aside>";
        } else{
           $html.= "<h3> Aucun utilisateur trouvé</h3>
	   <form action=\"index.php?action=search\" method=\"get\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<label for=\"recherche\">Modifier ma recherche :</label><input type=\"submit\" value=\"Ok !\">
	   </form><aside><a href = \"index.php\">Retour à l'accueil</a></aside>";
        }
       return $html;
    }
?>
