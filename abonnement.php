<?php
    function follow($id){
        if(!(isset($_SESSION['LOGGED_MDP'] ) && !isset( $_SESSION['LOGGED_PSEUDO']))){ header("Location : index.php?action=bienvenue");}
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    }

    function unFollow($id){
        if(!(isset($_SESSION['LOGGED_MDP'] ) && !isset( $_SESSION['LOGGED_PSEUDO']))){ header("Location : index.php?action=bienvenue");}
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    }

?>