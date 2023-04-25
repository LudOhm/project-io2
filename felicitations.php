<?php 
  function felicitations($modif){
   $message = $modif ? "Modifications enregistrées !" : "Merci pour votre inscription !";
   $mot = $modif ? "Modification" : "Inscription !";
   $html = "<html lang=\"fr\"> <head>
<meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link href=\"felicitation.css\" rel=\"stylesheet\">
<title>".$mot ."Réussie!</title>
 <script src=\"https://kit.fontawesome.com/b1ff4425a2.js\" crossorigin=\"anonymous\"></script>
</head>
<body>
  <h1>".$message."<h1>
  <form action=\"index.php?action=profil&amp;id=".$_COOKIE['user_id']."\" method=\"post\">
  <button type=\"submit\" class=\"btn1\"><i class=\"fa-sharp fa-solid fa-cat fa-lg\" style=\"color: #B67645;\"></i>Voir mon profil</button></form>
<form action=\"index.php\" method=\"post\">
<button type=\"submit\" formaction=\"index.php\" class=\"btn2\">
<i class=\"fa-sharp fa-solid fa-dog fa-flip-horizontal fa-lg\" style=\"color: #B67645;\"></i>Retour à l'accueil</button> </form>
</body></html>";
    return $html;
  }

?>

