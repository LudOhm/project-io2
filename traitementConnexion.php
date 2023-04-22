    <?php
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        // Validation du formulaire
        if (isset($_POST['mail']) &&  isset($_POST['mdp'])) {

            $stmt = $pdo->prepare('SELECT * FROM `users`');
			$stmt->execute();
			$posts = $stmt->fetchAll();

            foreach ($users as $user) {
                if (
                    $user['mail'] === $_POST['mail'] &&
                    $user['mdp'] === $_POST['mdp']
                ) {
                    $loggedUser = [
                        'mail' => $user['mail'],
                    ];
                } else {
                    $errorMessage = sprintf('Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                        $_POST['mail'],
                        $_POST['mdp']
                    );
                }
            }
        }
        ?>  
