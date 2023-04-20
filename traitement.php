<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    if(isset($_GET['Pseudo'])){
        $userPseudo= $_GET['Pseudo'];
    }       
    
?>