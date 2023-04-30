<?php
function print_form($modifier) {
  $mot = $modifier ? "Modifier mes informations" : "S'inscrire";
  $destination = $modifier ? "update" : "sauvegarder";
  //$valDate = strlen($date) > 0 ? '$date' : 'jj/mm/aaaa';
  // AJOUT PHOTO DE PROFIL ???? vrmnt si on a le temps

  $html =
    "<h2>$mot</h2>
    
    <form action='index.php?action=$destination' method='post'>
    <label for=\"pseudo\">Pseudo :</label>
    <input type=\"text\" id=\"pseudo\"  required=\"required\" name=\"Pseudo\" ";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_PSEUDO']."\">";
    }else{
     $html .= "placeholder=\"Votre pseudo\">";
    }
    $html.= "<br>
    <label for=\"nom\">Nom :</label>
    <input type=\"text\" id=\"nom\" required=\"required\" name=\"nom\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_NOM']."\">";
    }else{
     $html .= "placeholder=\"Votre nom\">";
    }
    $html.= "<br>
    <label for=\"prenom\">Prenom :</label>
    <input type=\"text\" id=\"prenom\"  required=\"required\" name=\"prenom\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_PRENOM']."\">";
    }else{
     $html .= "placeholder=\"Votre prénom\">";
    }
    $html.="<br>
    <label for=\"date\">Date de naissance :</label>
    <input type=\"date\" id=\"date\" required=\"required\" name=\"date\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_DATE']."\">";
    } else{
      $html .= ">";
    }
    $html .="<br>
    <label for=\"mail\">Adresse mail : </label>
    <input type=\"email\" id =\"mail\" name=\"mail\" required=\"required\" pattern=\"^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}\"";
    if($modifier) {
      $html .= "value= \"".$_SESSION['LOGGED_MAIL']."\">";
    }else{
     $html .= "placeholder=\"ex: toto@mail.com\">";
    }
    $html.="<br>
    <label for=\"mdp\">Mot de passe : </label>
    <input type=\"password\" name=\"mdp\" placeholder=\"mot de passe\">
    <br>
    <input type=\"submit\" value=\"$mot\">
    </form>";
  return $html;
}

function inscriptionValidee(){
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    
        if(isset($_POST['Pseudo'])){
            $stmt = $pdo -> prepare('SELECT user_pseudo FROM `Users`');
            $stmt -> execute();
            $users = $stmt -> fetchAll();
            foreach($users as $pseudo){
                if($pseudo == $_POST['Pseudo']){
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
            $users = $stmt->fetchAll();
            foreach($users as $mail){
                if($mail == $_POST['mail']){
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

        $sqlQuery = 'INSERT INTO Users(user_pseudo,user_prenom,user_nom,user_naissance,user_email,user_motdepasse) VALUES (:user_pseudo,:user_prenom,:user_nom,:user_naissance,:user_email,:user_motdepasse);';
        $insertUsers = $pdo->prepare($sqlQuery);
        $insertUsers->execute([
            'user_pseudo' => $userPseudo,
            'user_prenom' => $userprenom,
            'user_nom' => $usernom,
            'user_naissance' => $userdate,
            'user_email' => $usermail,
            'user_motdepasse' => $userpassword
        ]);
        
        $recupID = $pdo->prepare('SELECT * FROM Users WHERE user_pseudo = ? AND user_motdepasse = ?');
        $recupID->execute(array($userPseudo, $userpassword));
        
        $_SESSION['LOGGED_ID']= $recupID->fetch()['user_id'];
        $_SESSION['LOGGED_PSEUDO']= $userPseudo;
        $_SESSION['LOGGED_MDP'] = $userpassword;
        $_SESSION['LOGGED_PRENOM'] =  $userprenom ;
        $_SESSION['LOGGED_NOM']= $usernom;
        $_SESSION['LOGGED_DATE'] = $userdate ;
        $_SESSION['LOGGED_MAIL'] = $usermail ;
        return true;
      
}
?>
