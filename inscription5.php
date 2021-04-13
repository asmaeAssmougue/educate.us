<?php
session_start();
include('connexion_base.php');
$id=$_SESSION['id_user'];
if (isset($_POST['suivant5'])) {
  $sql="INSERT INTO `notification`(`user_id`, `notification_id`,  `type_activitie`) VALUES ('$id',0,'Vous avez été inscrit avec succès.BIENVENUE PARMI NOUS')";
  $rst=mysqli_query($link,$sql);
    header("location:Acceuil.php");
}   
else if(isset($_POST["precedant4"])){
   
  header("location:inscription4.php");
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
  <input type="submit" name="suivant5"  class="suivantBtn"  value="Suivant" >
  <input type="submit" name="precedant4"  class="precedantB"  value="precedant" >
  <h4>Suggestions de personne à suivre :</h4>
  <p>Quand vous suivez quelqu'un vous voyez ses Tweets dans votre fil d'actualités.</p>
  <h4>Vous pourriez etre intéressé par :</h4>
  <?php     $id=$_SESSION['id_user'] ;
           $sql7 ="SELECT * FROM `profile_information` WHERE `user_id` != '".$id."'";
            $resultat7=mysqli_query($link,$sql7);
        while($data7=mysqli_fetch_assoc($resultat7)){
          $user_id=$data7['user_id'];
          $sql8 ="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$user_id."'";
            $resultat8=mysqli_query($link,$sql8);
            $data8=mysqli_fetch_assoc($resultat8);
            $user_name=$data7['user_name'];
            $url=$data7['url'];
            $photo_profil=$data8['profile_choisi'];
            echo "<hr><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border:2px solid purple;border-radius: 50%;\"/> <a href=\"".$url."\">".$user_name."</a>"; 

                $sql14="SELECT * FROM `following` WHERE `follower_id`='". $_SESSION['id_user'] ."' AND following_id = '".$user_id."' ";
                $resultat14= mysqli_query($link,$sql14);
                 $data14= mysqli_fetch_array($resultat14);
                if(isset($data14)){
                  ?>
                   <a class="boutton" id="hrefFollowinsc<?php  echo $user_id;?>" href="inscription5.php?n=true&user_id=<?php  echo $user_id;?>&follow=false" style="width: auto;float: right;background-color: red;">Se désabonner</a> 
                  <?php
                  }
                  else{
                 ?>
                   <a class="boutton"  id="hrefFollowinsc<?php  echo $user_id;?>" href="inscription5.php?n=true&user_id=<?php  echo $user_id;?>&follow=true" style="width: auto;float: right;">s'abonner</a> 
              <?php } 
  }
      if(isset($_GET['follow']) && isset($_GET['user_id'])){
               $user_id=$_GET['user_id'];
               $follower_id=$_SESSION['id_user'];
               $following_id=$user_id;
        if($_GET['follow']=='true'){
          $sql12="INSERT INTO `following`(`follower_id`, `following_id`, `follow_up`, `date_follow`) VALUES ('$follower_id','$following_id',0,date('d-m-Y  H:i:s'))";
          $resultat12= mysqli_query($link,$sql12);

          ?>
        <script type="text/javascript">
                    document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").href="inscription5.php?n=true&user_id=<?php  echo  $user_id; ?>&follow=false";
                    document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").textContent="Se désabonner";
                     document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").style.backgroundColor="red";
        </script>
          <?php
        }
          else if($_GET['follow']=='false'){
          $sql13="DELETE FROM `following` WHERE `follower_id`='".$follower_id."' AND  `following_id`='".$following_id."'";
          $resultat13= mysqli_query($link,$sql13);

          ?>
        <script type="text/javascript">
                    document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").href="inscription5.php?n=true&user_id=<?php  echo   $user_id; ?>&follow=true";
                     document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").textContent="s'abonner";
                     document.getElementById("hrefFollowinsc<?php  echo $user_id;?>").style.backgroundColor="#015651";
          </script>
      <?php
      }
    }
       ?>
<br><br><a href="Acceuil.php" style="text-decoration: underline;color: #16a69e;cursor: pointer;font-weight: bold;">Passer pour le moment</a>

</form>
       
</div>
</body>
</html>

