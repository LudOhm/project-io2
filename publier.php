<?php
    function publier(){
        $html = "<html lang=\"fr\"> <head><meta charset="utf-8">
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
        </form></main></body></html>";

        echo $html;

        $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

    // il faut remplace pour mettre une variable qui prend l'id de la personne logged in
    $user_id = 1;
    if(isset ($_POST['submit'])){
        $post_title = $_POST['post_title'];
        $post_contenu = $_POST['post_contenu'];
        $post_picture = null;

        if (isset($_FILES['post_picture'])) {
            $fileName = $_FILES['post_picture']['name'];
            $fileExtension = explode('.',$fileName);
            $validExtensions = ['jpg','jpeg','png', 'mp4', 'avi', 'mov', 'flv'];
            if(!(in_array($fileExtension,$validExtensions))){echo  "<script type=\"text/javascript\">window.alert('Format du fichier invalide')</script>";}

            if($_FILES['post_picture']['error'] === 0) {
                $post_picture = file_get_contents($_FILES['post_picture']['tmp_name']);
               
            } else{
                echo "<script type=\"text/javascript\">window.alert('Une erreur est survenue, veuillez réessayer')</script>";

            }
        }
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, post_title, post_contenu, post_picture) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user_id, $post_title, $post_contenu, $post_picture]);
        echo "<script type=\"text/javascript\">window.alert('Publication publiée avec succès !')</script>";

        }
       
    }

}
    ?>
