<?php
    function follow($id){
        if(isset($_SESSION['LOGGED_MDP']) && isset($_SESSION['LOGGED_PSEUDO'])) {
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
      
        // verifie que le user a follow existe (je pense pas que c'est obligatoire mais bon)
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
            $stmt->execute([$id]);
            $user = $stmt->fetch();
      
            if(!$user) {
                echo "l' user n'existe pas.";
                return;
            }
      
        // si il est deja suivi
            $stmt = $pdo->prepare('SELECT * FROM Followings WHERE user_id = ? AND following_id = ?');
            $stmt->execute([$_SESSION['LOGGED_ID'], $id]);
            $followed = $stmt->fetch();
      
            if($followed) {
            //il va donc l'unfollow
                return unFollow($id);
            } 
            else{
      
                // sinon il va le follow
                $pdo->beginTransaction();
      
                $stmt = $pdo->prepare('INSERT INTO Followings (user_id, following_id) VALUES (?, ?)');
                $stmt->execute([$_SESSION['LOGGED_ID'], $id]);
      
                $stmt = $pdo->prepare('INSERT INTO Followers (user_id, followers_id) VALUES (?, ?)');
                $stmt->execute([$id, $_SESSION['LOGGED_ID']]);
      
                $pdo->commit();
      
                return;
            }
        }
    }
      

    function unFollow($id){
       if(isset($_SESSION['LOGGED_MDP']) && isset($_SESSION['LOGGED_PSEUDO'])){
            $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    
            $stmt = $pdo->prepare("DELETE FROM Followings WHERE user_id = :logged_id AND following_id = :id");
            $stmt->execute(array(':logged_id' => $_SESSION['LOGGED_ID'], ':id' => $id));
    
            $stmt = $pdo->prepare("DELETE FROM Followers WHERE user_id = :id AND followers_id = :logged_id");
            $stmt->execute(array(':logged_id' => $_SESSION['LOGGED_ID'], ':id' => $id));
       }
    }
    

?>
