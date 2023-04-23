<?php 
  function felicitations(){
   $html = "<html lang=\"fr\"> <head>
<meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
<link href=\"felicitation.css\" rel=\"stylesheet\">
<title>Inscription Réussie!</title>
 <script src=\"https://kit.fontawesome.com/b1ff4425a2.js\" crossorigin=\"anonymous\"></script>
</head>
<body>
  <h1>Merci pour votre inscription !<h1>
  <button type=\"submit\" formaction=\"index.php?action=profil\" class=\"btn\"><i class=\"fa-sharp fa-solid fa-cat fa-lg\" style=\"color: #B67645;\"></i>Voir mon profil</button>
<button type=\"submit\" formaction=\"index.php\" class=\"btn\">
  <i class=\"fa-sharp fa-solid fa-dog fa-flip-horizontal fa-lg\" style=\"color: #B67645;\"></i>Retour à l'acceuil</button> 
</body></html>";
    return $html;
  }

?>

