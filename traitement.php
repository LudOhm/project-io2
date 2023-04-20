<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    if(isset($_GET['Pseudo'])){
        $userPseudo= $_GET['Pseudo'];
    } 
    if(isset($_GET['nom'])){
        $usernom= $_GET['nom'];
    }   
    if(isset($_GET['prenom'])){
        $userprenom= $_GET['prenom'];
    }   
    if(isset($_GET['mail'])){
        $usermail= $_GET['mail'];
    }  
    if(isset($_GET['mdp'])&&isset($_GET['mdp2'])){
        $userpassword = $_GET['mdp'];
    }    

?>