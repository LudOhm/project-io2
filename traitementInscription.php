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
            $userPseudo= htmlspecialchars($_POST['Pseudo']);
        } else return false;
        
        if(isset($_POST['nom'])){
            $usernom= htmlspecialchars($_POST['nom']);
        } else return false;
        
        if(isset($_POST['prenom'])){
            $userprenom= htmlspecialchars($_POST['prenom']);
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
            $usermail= htmlspecialchars($_POST['mail']);
        } else return false;
    
        if(isset($_POST['mdp'])){
            $userpassword = sha1($_POST['mdp']); //crypter le mdp
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
        
        $recupID = $pdo->prepare('SELECT * FROM users WHERE user_pseudo = ? AND user_motdepasse = ?');
        $recupID->execute(array($userPseudo, $userpassword));
        
        $_SESSION['LOGGED_ID']= $recupID->fetch()['user_id'];
        $_SESSION['LOGGED_PSEUDO']= $user_pseudo;
        $_SESSION['LOGGED_MDP'] = $userpassword;
        return true;
       
        
        /*$loggedUser = [ /// mais ça sert à quoi ça en fait???
            'user_id' => $_POST['user_id']
        ];*/
        
    
 
        
}
?>
