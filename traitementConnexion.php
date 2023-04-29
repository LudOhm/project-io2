<?php 
    function connexion_check(){
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        // Validation du formulaire
        if (isset($_POST['login']) &&  isset($_POST['mdp'])) {
            $login = htmlspecialchars($_POST['login']);
            $mdp = sha1($_POST['mdp']);//decrypter le mdp
            $stmt = $pdo->prepare('SELECT * FROM `Users`');
            $stmt->execute();
            $user = $stmt->fetchAll();
    
            foreach ($user as $users) {
                if (( $users['user_email'] === $login ||  $users['user_pseudo'] === $login ) &&
                $users['user_motdepasse'] === $mdp) {
                    
                        $_SESSION['LOGGED_ID']= $users['user_id'];
                        $_SESSION['LOGGED_PSEUDO']= $users['user_pseudo'];
                        $_SESSION['LOGGED_MDP'] = $users['user_motdepasse'];
                        $_SESSION['LOGGED_PRENOM'] =  $users['user_prenom'];
                        $_SESSION['LOGGED_NOM']=$users['user_nom'];
                        $_SESSION['LOGGED_DATE'] = $users['user_naissance'];
                        $_SESSION['LOGGED_MAIL'] = $users['user_email'] ;
                       
                        return true;
                } 
            } 
            $errorMessage =  "Mot de passe et/ou nom d'utilisateur incorrect(s)";
            echo '<script type="text/javascript">window.alert("'.$errorMessage.'");</script>';
            return false;
    
        }else 
            $errorMessage =  "Veuillez remplir tous les champs";
            echo '<script type="text/javascript">window.alert("'.$errorMessage.'");</script>';
            return false;

       
    }
?>
