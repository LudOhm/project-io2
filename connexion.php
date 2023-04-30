<?php
    function print_Login(){
        $html = "
        <main>
        <h2>Connexion :</h2>
        <form action=\"index.php?action=check\" method=\"post\">
        <label for=\"mail\">Adresse mail ou nom d'utilisateur: </label>
        <input type=\"text\" id =\"login\" name=\"login\" required=\"required\">
        <br>
        <label for=\"mdp\">Mot de passe : </label>
        <input type=\"password\" name=\"mdp\" placeholder=\"mot de passe\">
        <br>
        <input type=\"submit\" value=\"Valider\">
        </form>
        </main><aside><p>Pas encore inscrit ? </p><a href=\"index.php?action=inscription\"> Rejoignez-nous!</a></aside>";
        return $html;
    }
    
    function deconnexion(){
         $_SESSION = array();
        session_destroy();
        header('Location: index.php');
        exit();
    }
?>
