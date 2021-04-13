<?php 
session_start(); 
include('connexion_base.php');
$id=$_SESSION['id_user'];
$user_name= $_SESSION['user_name'];
$photo_profil=$_SESSION['photo_profil'];
$sql="SELECT * FROM `profile_information` WHERE `user_id`='".$id."'";
$rst=mysqli_query($link,$sql);
$data=mysqli_fetch_assoc($rst);
$language=$data['language'];
$description=$data['description'];
$date_naissance=$data['date_naissance'];
$sql2="SELECT * FROM `user_formation` WHERE `user_id`='".$id."'";
$rst2=mysqli_query($link,$sql2);
$data2=mysqli_fetch_assoc($rst2);
$etab=$data2['nom_etablissment'];
$type_etab=$data2['type_etablissment'];
$niveau=$data2['niveau'];
$sql3="SELECT * FROM `user` WHERE `user_id`='".$id."'";
$rst3=mysqli_query($link,$sql3);
$data3=mysqli_fetch_assoc($rst3);
$email=$data3['email'];
$sql="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id` = '".$id."'";
$rst=mysqli_query($link,$sql);
$data=mysqli_fetch_assoc($rst);
$photoProfil=$data['profile_choisi'];
$sql="SELECT `image_id` FROM `profile_image` ORDER BY image_id DESC LIMIT 1";
$rst=mysqli_query($link,$sql);
$data=mysqli_fetch_assoc($rst);
$idimage=$data['image_id'];
if (isset($_POST['enregistrer'])) {
	$email=$_POST["email_tel"];
	$mot_passe=sha1($_POST['mot_passe']);
  	$passwordRepeat=sha1($_POST['mot_passe2']);
  	$type_etablissement=htmlspecialchars($_POST['type_etablissement']);
    $nom_etablissement=htmlspecialchars($_POST['nom_etablissement']);
    $niveau=htmlspecialchars($_POST['niveau_etude']);
    $language=htmlspecialchars($_POST['language']);
    $description=htmlspecialchars($_POST['description']);
    $date_naissance=$_POST['date_naissance'];

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
          $nom_photo=$idimage.".".$extension_upload;
          if(!move_uploaded_file($temp_name,$dossier.$nom_photo)){
          exit("Problem dans le telechargement de l'image, Ressayez");
          }
          $ph_name=$nom_photo;
        }
      else{
          $ph_name=$photoProfil;
        }


    $sql4="UPDATE `profile_information` SET `language`='$language',`description`='$description',`date_naissance`='$date_naissance' WHERE `user_id` = '".$id."'";
    $rst4=mysqli_query($link,$sql4);
	if($rst4!=true){
            header("location:parametres.php?erreur=1");
     }
     else{
		    $sql5="UPDATE `user_formation` SET `type_etablissment`='$type_etablissement',`nom_etablissment`='$nom_etablissement',`niveau`='$niveau' WHERE `user_id` = '".$id."' ";
		    $rst5=mysqli_query($link,$sql5);
			if($rst5!=true){
            header("location:parametres.php?erreur=1");
    	     }
     		else{
				    $sql6="UPDATE `user` SET `email`='$email',`password`='$mot_passe'  WHERE `user_id` = '".$id."'";
				    $rst6=mysqli_query($link,$sql6);

				   if($rst6!=true){
				            header("location:parametres.php?erreur=1");
				    }
				    else{
              $sql="UPDATE `profile_image` SET `profile_choisi`='$ph_name' WHERE `user_id` = '".$id."'";
              $resultat=mysqli_query($link,$sql);
              $_SESSION['photo_profil']=$ph_name;
               if($resultat!=true){
                    header("location:parametres.php?erreur=1");
                }
                else{
				    	      header("location:parametres.php?erreur=0");
                 }
				    }
		   }
    }
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Paramètres</title>
	   <meta charset="utf-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
         <link rel="stylesheet" type="text/css" href="style2.css">
         <link rel="stylesheet" type="text/css" media="screen and (max-width:800px)" href="petite_resolution.css">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">   
         <?php include("slidebar.php")?>
  <article style="width: 80%;float: right;padding-top: 50px;"> 
        <?php include("./includes/searchBar.php") ?>
     <div id="result-recherche" style="display: none;">
     <?php 
           if(isset($_GET['barre_recherche'])){
                ?>
                <script type="text/javascript">
                    document.getElementById("result-recherche").style.display="block";
                </script>
                <?php
                    $barre_recherche =$_GET['barre_recherche'];
 
            $sql7 ="SELECT * FROM `profile_information` WHERE  `user_name` LIKE  '%".$barre_recherche."%' ";
            $resultat7=mysqli_query($link,$sql7);
            $data7=mysqli_fetch_assoc($resultat7);
            if (isset($data7)) {
        while($data7=mysqli_fetch_assoc($resultat7)){
            $recherche=$data7['user_name'];
            $id_user_recherche=$data7['user_id'];
            $sql8="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id` = '". $id_user_recherche."'";
            $resultat8=mysqli_query($link,$sql8);
            $data8=mysqli_fetch_assoc($resultat8);
            $profile_image=$data8['profile_choisi'];
            $url=$data7['url'];
            echo "<img src=\"photo/$profile_image\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border:2px solid purple;border-radius: 50%;\"/> <a href=\"".$url."&choix=tweets\">".$recherche."</a><br>";
        }}
        else{
          echo "Il n'existe aucun contact avec ce nom";
        }
        }    
     ?>
      </div>
        <?php 

if(isset($_GET['erreur'])){
              $err = $_GET['erreur'];
                if($err==1 ){
                    echo "<h3 style='color:white; text-align:center;padding:10%;margin:10%;background-color:red;border-radius:25px'>Erreur lors de l'enregisstrement des données ! <a href='parametres.php'>Retour</a></h3>";
                }

              if($err==0){
                    echo "<h3 style='color:white; text-align:center;padding:10%;margin:10%;background-color:green;border-radius:25px'>Vos données ont été enregistrer avec succees  <a href='parametres.php'>Retour</a></h3>";
              }

            }
 else{
    

   ?>

     <form method="POST" action="" class="formInsc" enctype="multipart/form-data">
     	<hr><h3 class="titre" style="text-decoration: underline;color: #16a69e;font-weight: bold;">Information personnels :</h3><hr><br>
     	<label>Nom utilisateur :</label>
					<input type="text" class="form-control"  required="required" disabled="disabled" value="<?php echo "$user_name";?>"><br> 


					<label for="email_tel">N° téléphone / Email</label><br>
					<input type="email" name="email_tel" class="form-control" placeholder="Adresse email" required="required" value="<?php echo $email;?>"><br> 

					<label for="date_naissance">Date de naissance :   </label>
					<input type="date" name="date_naissance" value="<?php echo $date_naissance;?>"><br><br>

            <label for="photoProfil">photo de profil :</label>
            <input type="file" name="photoProfil">
      <br><hr> <h3 class="titre" style="text-decoration: underline;color: #16a69e;font-weight: bold;">Changer votre mot de passe</h3><hr><br>
            <input type="password"  class="form-control" name="mot_passe" placeholder="Mot de passe" id="mot_passe">
          <div id="a_m_mot_passe" class="choix" style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold; ">Afficher le mot de passe</div> <br>
          <label for="mot_passe2">Confirmer le mot de passe</label>
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
         <hr><h3 class="titre" style="text-decoration: underline;color: #16a69e;font-weight: bold;">Formation :</h3><hr><br>
            <div>
                    <label for="formation">Niveau d'étude :</label>
                    <input type="text" name="niveau_etude" class="form-control" value="<?php echo $niveau; ?>">
                    <label for="formation">Etablissement :</label>
                    <input type="text" name="type_etablissement" placeholder="Type d'établissement" class="form-control" value="<?php echo $type_etab; ?>"><br>
                    <input type="text" name="nom_etablissement" placeholder="Nom d'établissement" class="form-control" value="<?php echo $etab; ?>">
                    <label for="formation">Language :</label>
                    <input type="text" name="language" class="form-control" value="<?php echo $language; ?>">
            </div>
            <br><br>
            <textarea name="description"  class="form-control"  placeholder="Ecrire une description de vous........ " rows="5" cols="60" ><?php echo $description; ?></textarea><br>
            <input type="submit" name="enregistrer" value="Enregistrer" class="boutton"><br><br>

    </form>
<?php } ?>
    </article>
   </div>
</body>
</html>