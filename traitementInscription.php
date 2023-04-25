<?php 
    function inscriptionValidee(){
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    
        if(isset($_POST['Pseudo'])){
            $stmt = $pdo -> prepare('SELECT user_pseudo FROM `Users`');
            $stmt -> execute();
            $user = $stmt -> fetchAll();
            foreach($user as $users){
                if($user == $_POST['Pseudo']){
                    $message = "Ce nom d'utilisateur est déjà pris!";
                    echo "<script type=\"text/javascript\">window.alert(\"".$message."\");</script>";
                    return false;
                }
            }
            $userPseudo= $_POST['Pseudo'];
        } else return false;
        
        if(isset($_POST['nom'])){
            $usernom= $_POST['nom'];
        } else return false;
        
        if(isset($_POST['prenom'])){
            $userprenom= $_POST['prenom'];
        }else return false;
        
        if(isset($_POST['date'])){
            $userdate = $_POST['date'];
        } else return false;
        
        if(isset($_POST['mail'])){
            $stmt = $pdo->prepare('SELECT user_email FROM `Users`');
            $stmt->execute();
            $user = $stmt->fetchAll();
            foreach($user as $users){
                if($users == $_POST['mail']){
                    $message="Cette adresse mail est déjà associée à un compte !";
                    echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                    return false;
                }
            }
            $usermail= $_POST['mail'];
        } else return false;
    
        if(isset($_POST['mdp'])){
            $userpassword = $_POST['mdp'];
        } else return false; 

        $sqlQuery = 'INSERT INTO users(user_pseudo,user_prenom,user_nom,user_naissance,user_email,user_motdepasse) VALUES (:user_pseudo,:user_prenom,:user_nom,:user_naissance,:user_email,:user_motdepasse);';
        $insertUsers = $pdo->prepare($sqlQuery);
        $insertUsers->execute([
            'user_pseudo' => $userPseudo,
            'user_prenom' => $userprenom,
            'user_nom' => $usernom,
            'user_naissance' => $userdate,
            'user_email' => $usermail,
            'user_motdepasse' => $userpassword
        ]);
        $_SESSION['LOGGED_USER']= $_POST['user_id'];
        $loggedUser = [
            'user_id' => $_POST['user_id']
        ];
        setcookie('LOGGED_USER', $_SESSION['LOGGED_USER'], time()+3600, '/');

        return true;
}
?>
