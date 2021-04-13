<?php
session_start();
include('connexion_base.php');
if(isset($_POST['suivant2'])){
  $user_mot_pass=sha1($_POST['mot_passe']);
  $passwordRepeat=sha1($_POST['mot_passe2']);
  $user_email=$_SESSION['email'];
  $sql1=" INSERT INTO `user` (`user_id`, `email`, `password`, `date_de_creation`) VALUES (0, '$user_email' ,'$user_mot_pass',date('d-m-Y  H:i:s')) ";
  $resultat1=mysqli_query($link,$sql1);

  $sql2="SELECT `user_id` FROM `user` WHERE  `email` = '".$user_email."' ";
  $resultat2=mysqli_query($link,$sql2);
  $data=mysqli_fetch_array($resultat2);
       if(mysqli_num_rows($resultat2)>0){
        $_SESSION['id_user'] = $data['user_id'];
        if(empty($_POST['mot_passe']) || empty($_POST['mot_passe2'])){
        header("location:inscription2.php?error=emptyfields");
        exit();
      }
      else if($_POST['mot_passe']==$_POST['mot_passe2']){
    header("location:inscription3.php");
    exit();
  }
  else if($_POST['mot_passe']!=$_POST['mot_passe2']){

    header("location:inscription2.php?error=passwordcheck");
     exit();
   }
   
      }
      
}
  else if(isset($_POST["precedant1"])){
  header("location:inscription1.php");
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
          <h4 class="titre">Insérez votre mot de passe</h4>
           <input type="submit" name="suivant2"  class="suivantBtn"  value="Suivant" >
           <input type="submit" name="precedant1"  class="precedantB2"  value="precedant" >
            <input type="password"  class="form-control" name="mot_passe" placeholder="Mot de passe" id="mot_passe" minlength="8">
          <div id="a_m_mot_passe" class="choix" style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold; ">Afficher le mot de passe</div> <br>
          <label>Confirmer le mot de passe</label>
          <input type="password"  class="form-control" name="mot_passe2" id="mot_passe">
          <?php 
            if(isset($_POST['suivant2'])){
                if($_POST['mot_passe']!=$_POST['mot_passe2']){

                   echo "<span style=\"color:red\">Mot de passe incorrecte</span>";
                }
            }
           ?>
          <script type="text/javascript">
            document.getElementById("a_m_mot_passe").addEventListener("click",function(){afficher_masquer()});
            function afficher_masquer(){
                if (document.getElementById("a_m_mot_passe").textContent==="Afficher le mot de passe") {
                    document.getElementById("a_m_mot_passe").textContent="Masquer le mot de passe";
                      document.getElementById("mot_passe").type="text";
                  }
                  else if(document.getElementById("a_m_mot_passe").textContent==="Masquer le mot de passe") {
                    document.getElementById("a_m_mot_passe").textContent="Afficher le mot de passe";
                      document.getElementById("mot_passe").type="password";
                  } 
            }
          </script><br><br>
          </form>

  </div>
  </body>
  </html>	