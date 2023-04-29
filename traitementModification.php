<?php
/*cas de la modification des infos: recuperer l'utilisateur, valider ses nouvelles infos mais faire attention à la verification des infos*/

function modificationValidee(){

    //verifier pr vrmt etre sures mais en principe dans le html les champs sont marqués 'required'
    if(!isset($_POST['Pseudo'])|| !isset($_POST['mail'])|| !isset($_POST['mdp'])|| !isset($_POST)['prenom']|| !isset($_POST['nom'])|| !isset($_POST['date'])){
        $message = "Merci de remplir tous les champs";
        echo "<script type=\"text/javascript\">window.alert(\"".$message."\");</script>";
        return false;
    }

    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

    //d'abord extraire les informations de l'utilisateur connecté
    $infosLogged = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
    $infosLogged = $infosLogged->execute(array($_SESSION['LOGGED_ID']));
    $pseudo =  $infosLogged->fetch()['user_pseudo'];
    $nom = $infosLogged->fetch()['user_nom'];
    $prenom = $infosLogged->fetch()['user_prenom'];
    $mail= $infosLogged->fetch()['user_email'];
    $mdp = $infosLogged->fetch()['user_motdepasse'];
    $date = $infosLogged->fetch()['user_naissance'];
    $oldInfo = array(
        "oldPseudo" => $pseudo,
        "oldMail" => $mail,
        "oldMdp" => $mdp,
        "oldPrenom" => $prenom,
        "oldNom" => $nom,
        "oldDate" => $date // faire attention au format recuperer
    );

    // recuperer les données du formulaire ->htmlspecialchars ; sha1(); 

    $newInfo = array(
        "newPseudo"=> htmlspecialchars($_POST['Pseudo']),
        "newMail"=> htmlspecialchars($_POST['mail']),
        "newMdp"=> sha1($_POST['mdp']),
        "newPrenom"=> htmlspecialchars($_POST['prenom']),
        "newNom"=> htmlspecialchars($_POST['nom']),
        "newDate" => $_POST['date']
    );

 
    // Modifier les infos dans la base (si differentes nouvelles);

    // si nouveau pseudo/mail verifier qu'il n'est pas dans la base de données avant de modifer

    if($oldInfo['oldMail'] != $newInfo['newMail']){
        $stmt = $pdo->prepare('SELECT user_email FROM `Users` WHERE user_id != ?');
        $stmt->execute(array($_SESSION['LOGGED_ID']));
        $usersMail = $stmt->fetchAll();
        foreach($usersMail as $mail){
            if($mail == $newInfo['newMail']){
                $message="Cette adresse mail est déjà associée à un compte !";
                echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                return false;
            }
        }

        
        $modif = $pdo->prepare('UPDATE Users SET user_email = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newMail'], $_SESSION['LOGGED_ID']));

    }

    if($oldInfo['oldPseudo'] != $newInfo['newPseudo']){
        $stmt = $pdo -> prepare('SELECT user_pseudo FROM `Users` WHERE user_id != ?');
        $stmt->execute(array($_SESSION['LOGGED_ID']));
        $usersPseudo = $stmt -> fetchAll();
        foreach($usersPseudo as $pseudo){
            if($pseudo == $newInfo['newPseudo']){
                $message = "Ce nom d'utilisateur est déjà pris!";
                echo "<script type=\"text/javascript\">window.alert(\"".$message."\");</script>";
                return false;
            }
        }
        // si on arrive ici, pseudo valide donc on modifie dans la base

        $modif = $pdo->prepare('UPDATE Users SET user_pseudo = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newPseudo'], $_SESSION['LOGGED_ID']));
        
    }

    if($oldInfo['oldMdp'] != $newInfo['newMdp']){
        $modif = $pdo->prepare('UPDATE Users SET user_motdepasse = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newMdp'], $_SESSION['LOGGED_ID']));
    }

    if($oldInfo['oldPrenom'] != $newInfo['newPrenom']){
        $modif = $pdo->prepare('UPDATE Users SET user_prenom = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newPrenom'], $_SESSION['LOGGED_ID']));
    }

    if($oldInfo['oldNom'] != $newInfo['newNom']){
        $modif = $pdo->prepare('UPDATE Users SET user_nom = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newNom'], $_SESSION['LOGGED_ID']));
    }


    if($oldInfo['oldDate'] != $newInfo['newDate']){
        $modif = $pdo->prepare('UPDATE Users SET user_naissance = ? WHERE user_id = ? ');
        $modif->execute(array($newInfo['newDate'], $_SESSION['LOGGED_ID']));
    }

    return true;
}
?>
