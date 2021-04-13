<?php
session_start();
include('connexion_base.php');
if(isset($_POST['suivant4'])){
  $subject=$_POST['centreInteret'];
  $id=$_SESSION['id_user'];
  $sql6="INSERT INTO `centre_interet`(`subject_id`, `user_id`, `subject`) VALUES (0,'$id','$subject')";
   $resultat6=mysqli_query($link,$sql6);
   if(!empty($subject) && !empty($id)){
    header("location:inscription5.php");
    exit();
   }
}
 else if(isset($_POST["precedant3"])){
    $subject=$_POST['centreInteret'];
  $id=$_SESSION['id_user'];
  $sql6="INSERT INTO `centre_interet`(`subject_id`, `user_id`, `subject`) VALUES (0,'$id','$subject')";
   $resultat6=mysqli_query($link,$sql6);
  header("location:inscription3.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style2.css">
  <link rel="stylesheet" type="text/css" href="styleInscription.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style type="text/css">
		.error{
			color:red;
		}
	</style>
</head>
<body>
  <div class="container">
  	     <form method="POST" action="" class="formInsc">
  <img src="logo3.png" width="100" style="margin-left: 40%;">
 <input type="submit" name="suivant4"  class="suivantBtn"  value="Suivant" >
 <input type="submit" name="precedant3"  class="precedantB"  value="precedant" >
  <h4>Quels sont les sujets qui vous intéressent ?</h4>
  <p>Sélectionnez des sujets qui vous intéressent afin de personnaliser votres expérience, notamment pour trouver des personnes à suivre.</p>
  <input type="search"  placeholder=" Tapez vos centres d'interet...." id="rechercher" name="centreInteret" class="form-control"><br

  ><br><br><a href="inscription5.php" style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold;">Passer pour le moment</a>

</form>
  	</div>
  </body>
  </html>