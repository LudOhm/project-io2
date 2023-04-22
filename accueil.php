<?php session_start(); ?>

<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
        <link href="accueil.css" rel="stylesheet">
    </head>
<body>
	<header>
		<h1>InstaPets</h1>
	</header>

	<main>
		<h2>Postes récents</h2>
		<?php
			// Connecter à la base de donnée
			$pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

			$stmt = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = Users.user_id ORDER BY DESC LIMIT 20');
			$stmt->execute();
			$posts = $stmt->fetchAll();

			foreach ($posts as $post) {
				echo '<article>';
				echo '<h3>' . htmlspecialchars($post['post_title']) . '</h3>';
				echo '<p>' . $post['post_picture'] . '</p>';
				echo '<p>' . htmlspecialchars($post['post_contenu']) . '</p>';
				echo '<p class="meta">Posted by ' . htmlspecialchars($post['user_id']) . '</p>';
				echo '</article>';
			}
		?>
	</main>

    <aside>
        <form action="recherche.php" method="post">
          <input type="search" name="recherche" placeholder="Rechercher">
          <input type="submit" value="Ok !">
        </form>
        <ul>
          <li><a href="publier.php">Publier</a></li>
          <li><a href="profil.php">MonCompte</a></li>
        </ul>
      </aside>

    <?php include("footer.php") ?>
    
</body>
</html>