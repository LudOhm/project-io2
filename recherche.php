<?php
    function search(){
    
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `users` ORDER BY id DESC');
		$stmt->execute();
		$utilisateurs = $stmt->fetchAll();
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $recherche = htmlspecialchars($_GET['q']);
	    $html = "<h2>Résultat pour '".$_GET['q']."'</h2>";
            $stmt = $pdo->prepare('SELECT user_pseudo,user_id FROM `users` WHERE user_pseudo LIKE "%'.$recherche.'%" ORDER BY id DESC'); 
            $stmt->execute();
		    $utilisateurs = $stmt->fetchAll();

        }
        if($utilisateurs->rowCount() > 0){
            	while($user = $utilisateurs->fetchAll()){
            		$html.= "<li><a href=\"index.php?action=profil&amp;id=" .$user['user_id']."\" >".$user['user_pseudo']."</a>";
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
