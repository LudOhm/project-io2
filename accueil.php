<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
        <link href="accueil.css" rel="stylesheet">
    </head>
<body>
	<header>
		<h1>Bienvenue sur InstaPets</h1>
	</header>

	<main>
		<h2>Recent Posts</h2>
		<?php
			// Connect to the database
			$pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

			// Get the 20 most recent posts
			$stmt = $pdo->prepare('SELECT * FROM posts ORDER BY created_at DESC LIMIT 20');
			$stmt->execute();
			$posts = $stmt->fetchAll();

			// Display each post
			foreach ($posts as $post) {
				echo '<article>';
				echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
				echo '<p>' . htmlspecialchars($post['content']) . '</p>';
				echo '<p class="meta">Posted by ' . htmlspecialchars($post['author']) . ' on ' . htmlspecialchars($post['created_at']) . '</p>';
				echo '</article>';
			}
		?>
	</main>

    <aside>
        <form>
          <input type="search" name="q" placeholder="Rechercher">
          <input type="submit" value="Ok !">
        </form>
        <ul>
          <!-- <li><a href="#">Comptes</a></li> -->
          <li><a href="publier.php">Publier</a></li>
          <li><a href="profil.php">MonCompte</a></li>
        </ul>
      </aside>

	<footer>
		<p>&copy; 2023 InstaPets</p>
	</footer>


    
    
</body>
</html>