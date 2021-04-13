<!DOCTYPE html>
<html>
<head>
	<title>CONNEXION</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styleConnexion.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
  <div class="container-fluid page"> 
      <div class="page">
        <img src="logo3.png" width="300">
      <h1 class="grand-titre">Bienvenue </h1>
      <h1>vous pouvez vous connectez ou créer un nouveau compte </h1>
    <form action="" method="post">
        <input type="submit" name="connexion" value="Se connecter" class="boutton bouttonConnexion"><br>
        <input type="submit" name="inscription" value="S'inscrire" class="boutton bouttonInscription ">
    </form>
    </div>
</div>
<?php if (isset($_POST['connexion'])) {
  header("location:connexion.php");
}
else if(isset($_POST['inscription'])){
  header("location:inscription1.php");
} ?>
<footer>
  Cette page à été crée avec HTML5 CSS3 PHP MYSQL
</footer>
<body>
</html>