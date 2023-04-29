<?php 
  function felicitations($modif){
   $message = $modif ? "Modifications enregistrées !" : "Merci pour votre inscription !";
   $mot = $modif ? "Modification" : "Inscription !";
   $html = "<html lang=\"fr\"> <head>
<meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link href=\"felicitations.css\" rel=\"stylesheet\">
<title>".$mot ."Réussie!</title>
 <script src=\"https://kit.fontawesome.com/b1ff4425a2.js\" crossorigin=\"anonymous\"></script>
</head>
<body>
  <h1>".$message."<h1>
  <br>
  <button type=\"button\" class=\"btn1\"><i class=\"fa-sharp fa-solid fa-cat fa-lg\" style=\"color: #B67645;\"></i><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\" >Voir mon profil</a></button>
<button type=\"button\" class=\"btn2\">
<i class=\"fa-sharp fa-solid fa-dog fa-flip-horizontal fa-lg\" style=\"color: #B67645;\"></i><a href=\"index.php\">Retour à l'accueil</a></button>
</body></html>";
    return $html;
  }

?>

