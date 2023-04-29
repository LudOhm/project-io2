<?php

function likePost($post_id, $user_id, $is_liked) {
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');

    if(!isPostExist($post_id,$user_id)){
        //si le post n'existe pas on le like direct
        $stmt = $pdo->prepare("INSERT INTO Likes (post_id, user_id, is_liked) VALUES (?, ?, ?) ");
        $stmt->execute([$post_id, $user_id, true]);
        return;
    }else{
        if(!isPostLiked($post_id,$user_id)){
            $stmt = $pdo->prepare("UPDATE Likes SET is_liked = ? WHERE post_id = ? AND user_id = ?");
            $stmt->execute([true, $post_id, $user_id]);
            return;
        }else{
            //pour dislike le post si il avait été like avant
            $stmt = $pdo->prepare("UPDATE Likes SET is_liked = ? WHERE post_id = ? AND user_id = ?");
            $stmt->execute([false, $post_id, $user_id]);
        }
    }

}

//test si le post est like
function isPostLiked($post_id, $user_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $stmt = $pdo->prepare("SELECT * FROM Likes WHERE post_id = ? AND user_id = ? AND is_liked = ?");
    $stmt->execute([$post_id, $user_id, true]);
    return $stmt->rowCount() > 0;
      
}

//test si le post est deja dans la base
function isPostExist($post_id, $user_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM Likes WHERE post_id = :post_id AND user_id = :user_id AND is_liked = 1');
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

//compte le nb de likes pour un post donné
function countPostLikes($post_id, $pdo, ) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Likes WHERE post_id = ? AND is_liked = ?");
    $stmt->execute([$post_id, true]);
    return $stmt->fetchColumn();
  }
  



?>