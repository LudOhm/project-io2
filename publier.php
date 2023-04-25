<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
    </head>
<body> 
    <header> 
        <h1>InstaPets</h1>
        
    </header>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

    $user_id = $_COOKIE['LOGGED_USER'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $post_title = $_POST['post_title'];
        $post_contenu = $_POST['post_contenu'];

        //la photo est pas obligé
        $post_picture = null;
        if (isset($_FILES['post_picture']) && $_FILES['post_picture']['error'] === UPLOAD_ERR_OK) {
            $post_picture = file_get_contents($_FILES['post_picture']['tmp_name']);
        }

        $stmt = $pdo->prepare('INSERT INTO posts (user_id, post_title, post_contenu, post_picture) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user_id, $post_title, $post_contenu, $post_picture]);

    }
    ?>

<main>
		<h2>Nouvelle publication</h2>
		<form method="POST" enctype="multipart/form-data">
			<label for="post_title">Title:</label>
			<input type="text" name="post_title" required>

			<label for="post_contenu">Content:</label>
			<textarea name="post_contenu" rows="5" required></textarea>

			<label for="post_picture">Picture:</label>
			<input type="file" name="post_picture">

			<input type="submit" value="Create Post">
		</form>
	</main>

    
    
</body>
</html>