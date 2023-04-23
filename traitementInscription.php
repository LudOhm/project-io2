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
        $stmt = $pdo->prepare('SELECT user_email FROM `Users`');
        $stmt->execute();
        $user = $stmt->fetchAll();
        foreach($user as $users){
            if($users == $_POST['mail']){
                $message="l'email est déjà utilisé !";
                echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                header("Location: http://localhost:8888/project-io2/inscription.php");
                exit();

            }
        }
        $usermail= $_POST['mail'];
    }  
    if(isset($_POST['mdp'])){
        $userpassword = $_POST['mdp'];
    }   

    $sqlQuery = 'INSERT INTO users(user_pseudo,user_prenom,user_nom,user_email,user_motdepasse) VALUES (:user_pseudo,:user_prenom,:user_nom,:user_email,:user_motdepasse);';
    $insertUsers = $pdo->prepare($sqlQuery);
    $insertUsers->execute([
        'user_pseudo' => $userPseudo,
        'user_prenom' => $userprenom,
        'user_nom' => $usernom,
        'user_email' => $usermail,
        'user_motdepasse' => $userpassword
    ]);
    $_SESSION['LOGGED_USER']= $_POST['mail'];
    $loggedUser = [
        'mail' => $_POST['mail']
    ];

    header("Location: http://localhost:8888/project-io2/accueil.php");
    exit();
?>
