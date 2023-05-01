<?php
    function publier(){
        $html = "<main>
        <h2>Nouvelle publication</h2>
        <form method=\"POST\" enctype=\"multipart/form-data\">

        <label for=\"post_title\">Title:</label>
        <input type=\"text\" name=\"post_title\" required>
        
        <label for=\"post_contenu\">Content:</label>
        <textarea name=\"post_contenu\" rows=\"5\" required></textarea>
        
        <label for=\"post_picture\">Picture:</label>
        <input type=\"file\" accept=\".jpeg, .jpg, .png, .mp4, .avi, .mov, .flv\" name=\"post_picture\">
        
        <button type=\"submit\" name=\"submit\">Publier</button>
        </form></main>";


        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

        $user_id = $_SESSION['LOGGED_ID'];
        //qd le form a été envoyé
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post_title = $_POST['post_title'];
            $post_contenu = $_POST['post_contenu'];
            $post_picture = null;


     
                if(isset($_FILES['post_picture']['error']) && $_FILES['post_picture']['error'] == 0) {
                    $post_picture = file_get_contents($_FILES['post_picture']['tmp_name']);
                
                } else if((isset($_FILES['post_picture']['error'])) && $_FILES['post_picture']['error'] != 0){
                    $html.= "<script type=\"text/javascript\">window.alert('Une erreur est survenue, veuillez réessayer')</script><button type=\"button\"><a href=\"index.php?action=publier\">Réessayer</a></button>";
                    return $html;

                }
            

            $stmt = $pdo->prepare('INSERT INTO Posts (user_id, post_title, post_contenu, post_picture) VALUES (?, ?, ?, ?)');
            $stmt->execute([$user_id, $post_title, $post_contenu, $post_picture]);
            $html.= "<script type=\"text/javascript\">window.alert('Publication publiée avec succès !')</script><button type=\"button\"><a href=\"index.php\">Retour à mon fil d'actualité</a></button>";
            return $html;
            //A REPRENDRE UN PEU SURTOUT POUR GERER LES REDIRECTIONS 

        }
        //pour test mais du coup ça ne met pas dans la base de donnée jsp pq alors que le script javascript s'affiche bien
        return $html;
       
    }   

    function delet($id){//j'ai enlevé le html pour la suprression parce que cv poser probleme
	    $db = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
	    $stmt = $db->prepare("DELETE FROM Posts WHERE post_id = ?");
	    $stmt->execute([$id]);
    }

    function likePost($post_id, $user_id) {
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        if(!isPostLiked($post_id,$user_id)){
            //si la personne n'a jms like on créé la ligne
            $stmt = $pdo->prepare("INSERT INTO Likes (post_id, user_id) VALUES (?, ?) ");
            $stmt->execute([$post_id, $user_id]);
            return;
        }else{
                $stmt = $pdo->prepare("DELETE FROM Likes WHERE post_id = ? AND user_id = ?");
                $stmt->execute([$post_id, $user_id]);  
        }
    }
    
    //test si le post est deja dans la base donc like
    function isPostLiked($post_id, $user_id) {
        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
        $stmt = $pdo->prepare("SELECT * FROM Likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        return $stmt->rowCount() > 0;
      }



    ?>
