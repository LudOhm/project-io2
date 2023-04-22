<!DOCTYPE html> 
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
        <title>InstaPets</title> 
        <link href="accueil.css" rel="stylesheet">
    </head>
<body>

    <main>
        <h2>Bienvenue sur Instapets, le réseau sociale pour les détenteurs d'animaux qui veulent partager 
            et communiquer avec les autres détenteurs d'animaux qui partage un intérêt commun. 
        </h2>
        <br>
        <form action="connexion.php" method="post">
        <label for="connexion">déjà inscrit? : </label>
        <input type="submit" value="Se connecter">
        </form>
        <form action="inscription.php" method="post">
        <label for="inscription">nouvel arrivant? : </label>
        <input type="submit" value="S'inscrire">
        </form>

    </main>

    
</body>
</html>