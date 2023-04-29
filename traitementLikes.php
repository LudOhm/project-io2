<?php

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
  

//compte le nb de likes pour un post donné
function countPostLikes($post_id, $pdo, ) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    return $stmt->fetchColumn();
  }
  



?>