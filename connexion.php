<?php 
session_start();
include('connexion_base.php');
if(!empty($_SESSION['id_user'])){
  header("location:Acceuil.php");
}
else{
if(isset($_POST['se_connecter'])) {
	
			$email =htmlspecialchars($_POST['email']); 
		  $mot_passe=htmlspecialchars($_POST['mot_passe']);
		  $requete1 = "SELECT * FROM user where email = '".$email."' ";
      $resultat1 = mysqli_query($link,$requete1);
      $data1= mysqli_fetch_array($resultat1);
        
      if($data1['password']==sha1($mot_passe) and mysqli_num_rows($resultat1)>0) // nom d'utilisateur et mot de passe correctes
        	{
            $_SESSION['email']=$email;
            $_SESSION['id_user']=$data1['user_id'];
            $id=$_SESSION['id_user'];
            $sql="SELECT * FROM `profile_information` WHERE `user_id`= '".$id."'";
            $res= mysqli_query($link,$sql);
            $dt= mysqli_fetch_array($res);
            $_SESSION['user_name']=$dt['user_name'];
            $recupImage="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`= '".$id."'";
            $reslt= mysqli_query($link,$recupImage);
            $data= mysqli_fetch_array($reslt);
            $_SESSION['photo_profil']=$data['profile_choisi'];
              
        	    

           		header("location:Acceuil.php");
        	}
        	else
        	{
           	header('Location: connexion.php?erreur=1'); // utilisateur ou mot de passe incorrect
        	}
}

}

 ?>
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
  <style type="text/css">
    body{
      background-image: none;
    }
  </style>
</head>
<body>
  
        <form action="" method="post" class="formStyle"> 
         <img src="logo3.png" width="100" style="margin-left: 40%;"><br><br>
          <?php
                        if(isset($_GET['erreur'])){
                            $err = $_GET['erreur'];
                            if($err==1 )
                                echo "<p style='color:red;font-weight: bold;'>Utilisateur ou mot de passe incorrect</p>";
                        }
                        ?>
        <input type="email" name="email" required="required" placeholder="Email/Numéro de tétéphone" class="form-control"><br><br>
        <input type="password" name="mot_passe" required="required" placeholder="Mot de passe" class="form-control"><br><br>
        <input type="submit" name="se_connecter" value="Se connecter" class="boutton">
        </form>
        <a href="inscription1.php"  style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold;">Créer un nouveau compte</a>

<body>
</html>