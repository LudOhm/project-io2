<?php
/* la fonction peut être appelé depuis chaque endroit où des posts apparaissent soit depuis accueil.php et depuis profil.php
    gerer cote base;
    dans les tests il faudra bien verifier que la publication disparait de l'acceuil et du profil
*/
  function delete($id){//jsp si cet argument est bien mais je pense qu'il en faut un, cça serait l'id du post

    $html= "<html lang=\"fr\"> <head><meta charset=\"utf-8\">
    <title>InstaPets</title></head>
  <body>
	<h1>Suppression du post</h1>";

		// il faut changer les GET
		if (!isset($_GET['id'])) {
			$html .= "<p>Error: pas de post selectionner.</p>";
		} else {
			$id = $_GET['id'];

			// supprime da la base de donnée
			$db = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
			$stmt = $db->prepare("DELETE FROM Posts WHERE post_id = ?");
			$stmt->execute([$id]);

			$html.="<p>Le post a été supprimé</p>";
		}


	$html.="<a href=\"index.php\">retour à l'acceuil</a></body></html>";
	 return $html;

  }


?>
