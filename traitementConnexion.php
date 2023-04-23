<?php
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    // Validation du formulaire
    if (isset($_POST['mail']) &&  isset($_POST['mdp'])) {

        $stmt = $pdo->prepare('SELECT * FROM `Users`');
        $stmt->execute();
        $user = $stmt->fetchAll();


    if (!empty($user)) {
        foreach ($user as $users) {
            if (!empty($users['user_email']) && !empty($users['user_motdepasse'])) {
                if ($users['user_email'] == $_POST['mail'] && $users['user_motdepasse'] == $_POST['mdp']) {
                    $_SESSION['LOGGED_USER']= $users['user_email'];
                    $loggedUser = [
                        'mail' => $_POST['mail']
                    ];
                    break;
                }
            }
        }
    }
    
    if (empty($loggedUser)) {
        header("Location: http://localhost:8888/project-io2/inscription.php");
        exit();
    }
    header("Location: http://localhost:8888/project-io2/accueil.php");
    exit();
}
    ?>
