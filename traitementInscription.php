<?php 
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
    
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $sqlQuery = 'INSERT INTO users(user_pseudo,user_prenom,user_nom,user_email,user_motdepasse) VALUES (:user_pseudo,:user_prenom,:user_nom,:user_email,:user_motdepasse);';
    $insertUsers = $pdo->prepare($sqlQuery);
    $insertUsers->execute([
        'user_pseudo' => $userPseudo,
        'user_prenom' => $userprenom,
        'user_nom' => $usernom,
        'user_email' => $usermail,
        'user_motdepasse' => $userpassword
    ]);
    $loggedUser = [
        'mail' => $_POST['mail']
    ];

    header("Location: http://localhost:8888/project-io2/accueil.php");
    exit();
?>
