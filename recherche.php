<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
    </head>
<body> 
    <header> 
        <h1>InstaPets </h1>
        
    </header>

    <main>
    <?php
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');


        $stmt = $pdo->prepare('SELECT user_pseudo FROM `users`');
		$stmt->execute();
		$users_pseudo = $stmt->fetchAll();

        foreach ($users_pseudo as $user) {
            if($users_pseudo==$_POST['recherche']){
                echo '<article>';
                //il faut mettre le lien vers le profil du compte associer
                echo '<p>' . htmlspecialchars($user['user_pseudo']) . '</p>';
                echo '</article>';
            }
        }

    ?>
    </main>

    <?php include("footer.php") ?>
</body>
</html>