<?php
    function publier(){
        $html = "<html lang=\"fr\"> <head><meta charset=\"utf-8\">
        <title>InstaPets</title></head>
        <body><main>
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

        $user_id = $_SESSION['LOGGED_ID'];;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post_title = $_POST['post_title'];
            $post_contenu = $_POST['post_contenu'];
            $post_picture = null;


            if (isset($_FILES['post_picture']['error']) && $_FILES['post_picture']['error'] === UPLOAD_ERR_OK) {
                //$fileName = $_FILES['post_picture']['name'];
                //$fileExtension = explode('.',$fileName);
                //$validExtensions = ['jpg','jpeg','png', 'mp4', 'avi', 'mov', 'flv'];
                // if(!(in_array($fileExtension,$validExtensions))){
                //     $html.=  "<script type=\"text/javascript\">window.alert('Format du fichier invalide')</script><button type=\"button\"><a href=\"index.php?action=publier\">Réessayer</a></button></body></html>";
                //     return $html;
                // }

                if($_FILES['post_picture']['error'] === 0) {
                    $post_picture = file_get_contents($_FILES['post_picture']['tmp_name']);
                
                } else{
                    $html.= "<script type=\"text/javascript\">window.alert('Une erreur est survenue, veuillez réessayer')</script><button type=\"button\"><a href=\"index.php?action=publier\">Réessayer</a></button></body></html>";
                    return $html;

                }
            }
            
            $stmt = $pdo->prepare('INSERT INTO Posts (user_id, post_title, post_contenu, post_picture) VALUES (?, ?, ?, ?)');
            $stmt->execute([$user_id, $post_title, $post_contenu, $post_picture]);
            $html.= "<script type=\"text/javascript\">window.alert('Publication publiée avec succès !')</script><button type=\"button\"><a href=\"index.php\">Retour à mon fil d'actualité</a></button></body></html>";
            return $html;
            //A REPRENDRE UN PEU SURTOUT POUR GERER LES REDIRECTIONS 

        }
        //pour test mais du coup ça ne met pas dans la base de donnée jsp pq alors que le script javascript s'affiche bien
        return $html;
       
    }   


    ?>
