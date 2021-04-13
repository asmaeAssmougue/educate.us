<?php
session_start();
include('connexion_base.php');
if(isset($_POST['suivant3'])){
  $id=$_SESSION['id_user'] ;
  $type_etablissement=htmlspecialchars($_POST['type_etablissement']);
  $nom_etablissement=htmlspecialchars($_POST['nom_etablissement']);
  $niveau_etude=htmlspecialchars($_POST['niveau_etude']);
  $language=htmlspecialchars($_POST['language']);
  $sql3="INSERT INTO `user_formation` (`user_id`, `formation_id`, `type_etablissment`, `nom_etablissment`, `niveau`) VALUES ('$id', 0 , '$type_etablissement', '$nom_etablissement','$niveau_etude')";
   $resultat3=mysqli_query($link,$sql3);

   $description=htmlspecialchars($_POST['description_user']);

    if(($_FILES['photoProfil']['error']==0)){
      $dossier= 'photo/';
          $temp_name=$_FILES['photoProfil']['tmp_name'];
          if(!is_uploaded_file($temp_name))
          {
          exit("le fichier est untrouvable");
          }
          if ($_FILES['photoProfil']['size'] >= 1000000){
            exit("Erreur, le fichier est volumineux");
          }
          $infosfichier = pathinfo($_FILES['photoProfil']['name']);
          $extension_upload = $infosfichier['extension'];
          
          $extension_upload = strtolower($extension_upload);
          $extensions_autorisees = array('png','jpeg','jpg');
          if (!in_array($extension_upload, $extensions_autorisees))
          {
          exit("Erreur, Veuillez inserer une image svp (extensions autorisées: png)");
          }
          $nom_photo=$id.".".$extension_upload;
          if(!move_uploaded_file($temp_name,$dossier.$nom_photo)){
          exit("Problem dans le telechargement de l'image, Ressayez");
          }
          $ph_name=$nom_photo;
        }
      else{
          $ph_name="inconnu.jpg";
        }
        $sql4="INSERT INTO `profile_image`(`image_id`, `profile_default`, `profile_choisi`, `user_id`) VALUES (0,'inconnu.jpg', '$ph_name','$id')";
        $resultat4=mysqli_query($link,$sql4);
        $user_name= $_SESSION['user_nom'];
        $user_prenom= $_SESSION['user_prenom'];
$user_name=$user_name.$user_prenom.$id;
$date_naissance= $_SESSION['date_naissance'];
$_SESSION['user_name']=$user_name;
$url="profil.php?user_name=".$user_name;
        $sql5="INSERT INTO `profile_information`(`user_id`, `profile_id`, `user_name`, `language`, `url`, `description`, `date_naissance`) VALUES ('$id',0,'$user_name','$language','$url','$description','$date_naissance')";
         $resultat5=mysqli_query($link,$sql5);
          $_SESSION['photo_profil']=$ph_name;
          if(isset($_POST['suivant3']) &&  $type_etablissement != "" && $nom_etablissement != "" && $niveau_etude != "" &&  $language != ""){
  header("location:inscription4.php");
  exit();
}
}
else if(isset($_POST["precedant2"])){
  header("location:inscription2.php");
  exit();
}
else if(isset($_POST['passer'])){
$description="";
$type_etablissement="";
$nom_etablissement="";
$niveau_etude="";
$language="";
$ph_name="inconnu.jpg";
$id=$_SESSION['id_user'] ;
$user_name= $_SESSION['user_nom'];
$user_prenom= $_SESSION['user_prenom'];
$user_name=$user_name.$user_prenom.$id;
$date_naissance= $_SESSION['date_naissance'];
$_SESSION['user_name']=$user_name;
$_SESSION['photo_profil']=$ph_name;
$url="profil.php?user_name=".$user_name;
   $sql3="INSERT INTO `user_formation` (`user_id`, `formation_id`, `type_etablissment`, `nom_etablissment`, `niveau`) VALUES ('$id', 0 , '$type_etablissement', '$nom_etablissement','$niveau_etude')";
   $resultat3=mysqli_query($link,$sql3);
   $sql4="INSERT INTO `profile_image`(`image_id`, `profile_default`, `profile_choisi`, `user_id`) VALUES (0,'inconnu.jpg', '$ph_name','$id')";
  $resultat4=mysqli_query($link,$sql4);
   $sql5="INSERT INTO `profile_information`(`user_id`, `profile_id`, `user_name`, `language`, `url`, `description`, `date_naissance`) VALUES ('$id',0,'$user_name','$language','$url','$description','$date_naissance')";
         $resultat5=mysqli_query($link,$sql5);
           header("location:inscription4.php");
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
    <form method="POST" action="" class="formInsc" enctype="multipart/form-data">
<img src="logo3.png" width="100" style="margin-left: 40%;">
            <h4 class="titre">Choisissez une photo de profil et une description</h4>
            <div class="image_upload">
              <label for="photo_profil">
                <img src="placeholder.png" id="placeholder_image" style="width: 100px;height: 100px; border:10px solid #015651;border-radius: 50%;" >
              </label>
            <b>Veuillez choisir une photo de profil</b><input type="file" name="photoProfil" id="photo_profil" onchange='openFile(event)'/>

          <script>
            var openFile = function(event) {
              var input = event.target;
              var reader = new FileReader();
              reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('placeholder_image');
                output.src = dataURL;
              };
              reader.readAsDataURL(input.files[0]);
            };
          </script>
            </div><br><br>
            <div>
              <h4><b>Votre formation </b></h4>
                    <label for="formation">Niveau d'étude :</label>
                    <input type="text" name="niveau_etude" class="form-control">
                    <label for="formation">Etablissement :</label>
                    <input type="text" name="type_etablissement" placeholder="Type d'établissement" class="form-control"><br>
                    <input type="text" name="nom_etablissement" placeholder="Nom d'établissement" class="form-control">
                    <label for="formation">Language :</label>
                    <input type="text" name="language" class="form-control">
            </div>
            <br><br>
            <textarea name="description_user"  class="form-control" placeholder="Ecrire une description de vous........ " rows="5" cols="60"></textarea><br>
         <input type="submit" name="passer" value="Passer pour le moment"  style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold;background-color: transparent;border: none;">
            <input type="submit" name="suivant3" class="suivantBtn" value="Suivant">
            <input type="submit" name="precedant2"  class="precedantB3"  value="precedant" >

          </form>
    </div>
  </body>
  </html>