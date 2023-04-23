
<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
        <link rel="stylesheet" href="inscription.css">
    </head>
<body> 


    <header> 
        <h1>InstaPets</h1>
        <hr>
    </header>

    <main>

    <?php if(!isset($_SESSION['LOGGED_USER'])): ?>

        <h2>Connexion :</h2>

      <form action="traitementConnexion.php" method="post">
        <label for="mail">Adresse mail : </label>
        <input type="email" id ="mail" name="mail" required="required">
        <br>
        <label for="mdp">Mot de passe : </label>
        <input type="password" name="mdp" placeholder="mot de passe">
        <br>
        <input type="submit" value="Valider">
      </form>

    <?php endif; ?>
    </main>

    <?php include("footer.php") ?>

</body>
</html>
