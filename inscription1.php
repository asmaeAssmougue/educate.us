<?php
session_start();
include('connexion_base.php');
  $validation_error = "";
  $user_email= "";
  $user_nom="";
  $user_prenom="";
  $user_tel="";
  $date_naissance="";
  function validation($array){
    foreach($array as $key=>$data){
      $data=trim($data);
      $data=stripslashes($data);
      $data=htmlspecialchars($data);
  }
  return $array;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
if (isset($_POST['suivant1'])) {
    $_POST=validation($_POST);
    $_SESSION['user_nom']=$_POST["nom"];
    $_SESSION['user_prenom']=$_POST["prenom"];
    if(!empty($_POST['tel'])){
        $_SESSION['email']=$_POST["tel"];
    }
    if(!empty($_POST['email'])){
         $_SESSION['email']=$_POST["email"];
     }
    $_SESSION['date_naissance']=$_POST["date_naissance"];
   if(array_key_exists("email",$_POST) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        
        $validation_error = "* Veuillez entrer une adresse email valide. ";
      } 
       header("location:inscription2.php");
  }
 
  
  } ?>
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
					<h4 class="titre">Creer votre compte en quelque secondes</h4>
          <button type="submit" name="suivant1" value="Suivant" class="suivantBtn" id="suivant1">Suivant</button>
					<input type="text" name="nom" class="form-control" placeholder="Votre nom" required="required" value="<?php echo $user_nom ?>"><br>
					<input type="text" name="prenom" class="form-control" placeholder="Votre prenom" required="required" value="<?php echo $user_prenom;?>"><br>
					<input type="email" name="email" class="form-control" placeholder="Adresse email" required="required" id="placeholder_tel_email" value="<?php echo $user_email;?>"><br> 

					<div id="tel_email" class="choix" style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold;">S'inscrire avec votre N° téléphone</div>
				 <p id="error"></p>
					 <script type="text/javascript">
					 		document.getElementById("tel_email").addEventListener("click",function(){mafct()});
					 		function mafct(){
					 			if (document.getElementById("tel_email").textContent==="S'inscrire avec votre N° téléphone") {
					 				document.getElementById("tel_email").textContent="S'inscrire avec votre adresse mail";
					 	    		document.getElementById("placeholder_tel_email").placeholder="Téléphone";
					 	    		document.getElementById("placeholder_tel_email").type="text";
					 	    		document.getElementById("placeholder_tel_email").name="tel";
                    document.getElementById("placeholder_tel_email").id="placeholder_tel";
                    document.getElementById("placeholder_tel_email").value="<?php $user_tel;?>";
					 	    	}
					 	    	else if(document.getElementById("tel_email").textContent==="S'inscrire avec votre adresse mail") {
					 				document.getElementById("tel_email").textContent="S'inscrire avec votre N° téléphone";
					 	    		document.getElementById("placeholder_tel_email").placeholder="Adresse email";
					 	    	}	
					 	    }			
					 </script>



					<h4>Date de naissance :</h4>
					<input type="date" name="date_naissance" value="<?php echo $date_naissance;?>"><br><br>
				</form>
</div>
</body>
</html>

