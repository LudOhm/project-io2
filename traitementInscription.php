<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    if(isset($_POST['Pseudo'])){
        $userPseudo= $_POST['Pseudo'];
    } 
    if(isset($_POST['nom'])){
        $usernom= $_POST['nom'];
    }   
    if(isset($_POST['prenom'])){
        $userprenom= $_POST['prenom'];
    }   
    if(isset($_POST['mail'])){
        $usermail= $_POST['mail'];
    }  
    if(isset($_POST['mdp'])){
        $userpassword = $_POST['mdp'];
    }    

?>
