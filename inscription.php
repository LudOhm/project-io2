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
        <h2>S'inscrire</h2>

      <form action="traitement.php" method="post">
      <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" placeholder="Pseudo" required="required" name="Pseudo">
        <br>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" placeholder="Nom" required="required" name="nom">
        <br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" placeholder="Prenom" required="required" name="prenom">
        <br>
        <label for="mail">Adresse mail : </label>
        <input type="email" id ="mail" name="mail" required="required">
        <br>
        <label for="mdp">Mot de passe : </label>
        <input type="password" name="mdp" placeholder="mot de passe">
        <br>
        <input type="submit" value="Valider">
      </form>

    </main>

    <?php include("footer.php") ?>

</body>
</html>