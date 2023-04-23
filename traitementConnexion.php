<?php 
    function connexion_check(){
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        // Validation du formulaire
        if (isset($_POST['login']) &&  isset($_POST['mdp'])) {
    
            $stmt = $pdo->prepare('SELECT user_pseudo, user_email, user_motdepasse FROM `Users`');
            $stmt->execute();
            $user = $stmt->fetchAll();
    
            foreach ($user as $users) {
                if (( $users['user_email'] === $_POST['login'] ||  $users['user_pseudo'] === $_POST['login'] ) &&
                $users['user_motdepasse'] === $_POST['mdp']) {
                        $loggedUser = [
                            'mail' => $users['user_mail']
                        ];
                    return true;
                } 
            } 
            $errorMessage =  "Mot de passe et/ou nom d'utilisateur incorrect(s)";
            echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
            return false;
    
        }else return false;

       
    }
?>