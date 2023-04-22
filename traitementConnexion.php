<?php
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    // Validation du formulaire
    if (isset($_POST['mail']) &&  isset($_POST['mdp'])) {

        $stmt = $pdo->prepare('SELECT * FROM `Users`');
        $stmt->execute();
        $user = $stmt->fetchAll();

        foreach ($user as $users) {
            if (
                $users['user_email'] === $_POST['mail'] &&
                $users['user_motdepasse'] === $_POST['mdp']
            ) {
                $loggedUser = [
                    'mail' => $_POST['mail']
                ];
            } else {
                $errorMessage = sprintf('Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                    $_POST['mail'],
                    $_POST['mdp']
                );
            }
        }
    }
    header("Location: http://localhost:8888/project-io2/accueil.php");
    exit();
    ?>
