<?php 
session_start(); 
include('connexion_base.php');
$id=$_SESSION['id_user'];
$user_name= $_SESSION['user_name'];
if(!empty($id) ){
        if(isset($_GET['deconnexion']))
                { 
                   if($_GET['deconnexion']==true)
                   {  
                      session_destroy();
                      header("location:connexion.php");
                   }
        }
     if(isset($_POST['envoyer'])) {
        if ((isset($_GET['message'])) && isset($_GET['id_user_dest']) && isset($_GET['id_user_exp']) && isset($_POST['text_msg'])) {
        	$text_msg=$_POST['text_msg'];
        	$id_user_dest=$_GET['id_user_dest'];
        	$id_user_exp=$_GET['id_user_exp'];
        	$sql="INSERT INTO `message`(`message_text`, `message_id`, `date_message`, `id_user_dest`, `id_user_exp`) VALUES ('$text_msg',0,date('d-m-Y  H:i:s'),'$id_user_dest','$id_user_exp')";
        	$resultat=mysqli_query($link,$sql);
$user_name=$_SESSION['user_name'];
           $sql="INSERT INTO `notification`(`user_id`, `notification_id`, `type_activitie`) VALUES ('$id_user_dest',0,'Vous avez un nouveau message de $user_name.<a href=\"message.php?id_user=$id_user_dest\"> Voir le message</a>')";
          $rst=mysqli_query($link,$sql);
           header("location:message.php?id_user=$id_user_dest");
        }
   
       elseif ((isset($_GET['message'])) && isset($_POST['destinataire'])&& isset($_POST['text_msg'])) {
          $destinataire=htmlspecialchars($_POST['destinataire']);
          $sqll="SELECT `user_id` FROM `profile_information` WHERE `user_name` = '".$destinataire."'";
          $rstt=mysqli_query($link,$sqll);
          $dataa=mysqli_fetch_assoc($rstt);
          if($dataa!=true){
            header("location:message.php?message=newmessage&erreur=1");
          }
          else{
          $text_msg=$_POST['text_msg'];
          $id_user_dest=$dataa['user_id'];
          $id_user_exp=$_SESSION['id_user'];
          $sql="INSERT INTO `message`(`message_text`, `message_id`, `date_message`, `id_user_dest`, `id_user_exp`) VALUES ('$text_msg',0,date('d-m-Y  H:i:s'),'$id_user_dest','$id_user_exp')";
          $resultat=mysqli_query($link,$sql);

          $user_name=$_SESSION['user_name'];
           $sql="INSERT INTO `notification`(`user_id`, `notification_id`, `type_activitie`) VALUES ('$id_user_dest',0,'Vous avez un nouveau message de $user_name.<a href=\"message.php?id_user=$id_user_dest\"> Voir le message</a>')";
          $rst=mysqli_query($link,$sql);
          header("location:message.php?id_user=$id_user_dest");
        }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Messages</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" type="text/css" href="style2.css">
      <link rel="stylesheet" type="text/css" media="screen and (max-width:800px)" href="petite_resolution.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>	
</head>
<body>
<div class="container">   
                         <?php include("slidebar.php")?>
  <div class="page"> 
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
            </form>
  <h2 class="titre">Messages</h2>
  <hr>
  <?php 

if(isset($_GET['erreur'])){
              $err = $_GET['erreur'];
                if($err==1 )
                    echo "<h3 style='color:white; text-align:center;padding:10%;margin:10%;background-color:red;border-radius:25px'>Erreur lors de l'envoi du message veuillez verifier le nom du destinataire saisie ! <a href='message.php'>Retour</a></h3>";

            }

   ?>
        <ul class="navBarmsg" >
        	<li><a href="message.php?message=newmessage"><button><img src="newmsg.png" width="50px">Nouveau message</button></a></li>
        </ul>
         <form action="" method="post">
        <?php  if (isset($_GET['message']) && $_GET['message']=='newmessage') {
        	if (isset($_GET['id_user_dest']) && isset($_GET['id_user_exp'])){			
         		$id_user_dest=$_GET['id_user_dest'];
         		$id_user_exp=$_GET['id_user_exp'];
         		$sql="SELECT `user_name` FROM `profile_information` WHERE `user_id`= '".$id_user_dest."'";
         		$resultat=mysqli_query($link,$sql);
         		$data= mysqli_fetch_array($resultat);
         		$user_name=$data['user_name'];
         		?>

         <input type="text" name="destinataire" value=" <?php echo $user_name; ?>" style="display: block;width:100%;">
          <?php
         		}
         		else{
         			?>
         <input type="text" name="destinataire" placeholder=" Choisissez un destinataire" style="display: block;width:100%;">
         			<?php
         		}
         ?>
        	<br><textarea name="text_msg"  class="tweet" placeholder="Veuillez tapez votre message ici... " rows="5" cols="100" style="border:1px solid black;width:100%;"></textarea><br>
        	<button name="envoyer" class="boutton" style="width: auto;">Envoyer</button>
         </form>
        <?php
        }
      if(isset($_GET['id_user']) ){
              $id_user=$_GET['id_user'];
              ?>
          <form action="" method="post">
        <?php   
            $id_user_dest=$id_user;
            $id_user_exp=$id;
            $sql="SELECT `user_name` FROM `profile_information` WHERE `user_id`= '".$id_user_dest."'";
            $resultat=mysqli_query($link,$sql);
            $data= mysqli_fetch_array($resultat);
            $user_name=$data['user_name'];
            ?>
          <textarea name="text_msg" placeholder="Veuillez tapez votre message ici... " rows="5" cols="100" style="border:1px solid black;width:100%;"></textarea>
          <button name="envoyer"  class="boutton" style="width: auto;">Envoyer</button>
         </form>

              <?php

          if(isset($_POST['envoyer'])) {
          $text_msg=$_POST['text_msg'];
          $sql="INSERT INTO `message`(`message_text`, `message_id`, `date_message`, `id_user_dest`, `id_user_exp`) VALUES ('$text_msg',0,date('d-m-Y  H:i:s'),'$id_user_dest','$id_user_exp')";
          $resultat=mysqli_query($link,$sql);

          $user_name=$_SESSION['user_name'];
           $sql="INSERT INTO `notification`(`user_id`, `notification_id`, `type_activitie`) VALUES ('$id_user_dest',0,'Vous avez un nouveau message de $user_name.<a href=\"message.php?id_user=$id_user_dest\"> Voir le message</a>')";
          $rst=mysqli_query($link,$sql);
    }
                $sql="SELECT * FROM `message` WHERE `id_user_exp`= '".$id_user."' OR  `id_user_dest`= '".$id_user."' ORDER BY `date_message` DESC";
              $resultat=mysqli_query($link,$sql);
              while($data=mysqli_fetch_assoc($resultat)){
                    $text_msg=$data['message_text'];
                    $date_msg=$data['date_message'];
                    $text_msg=$data['message_text'];
                    $id_user_dest=$data['id_user_dest'];
                    $id_user_exp=$data['id_user_exp'];
                    $sql2="SELECT `user_name` FROM `profile_information` WHERE `user_id`='".$id_user_exp."'";
                    $resultat2=mysqli_query($link,$sql2);
                    $data2=mysqli_fetch_assoc($resultat2);
                    $user_name=$data2['user_name'];
                     $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$id_user_exp."'";
                    $resultat14=mysqli_query($link,$sql14);
                    $data14=mysqli_fetch_assoc($resultat14);
                    if($id_user_exp!=$id){
                       $user_name=$data2['user_name']; 
                       $photo_profil=$data14['profile_choisi'];
                        echo "<hr><div class=\"text_tweet recue\"> <img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/>  <a href=\"profil.php?user_name=$user_name\"> $user_name : </a> $text_msg <span class=\"date_tweet\" >$date_msg</span> </div>";
                  } 
                  else{ $name='Vous';$photo_profil=$_SESSION['photo_profil']; 
                  $user_name=$_SESSION['user_name'];
                     echo "<hr><div class=\"text_tweet envoye\"> <img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/>  <a href=\"profil.php?user_name=$user_name\"> $name : </a> $text_msg <span class=\"date_tweet\" >$date_msg</span> </div>";
                   }
                }

            }
            else{
            	$sql="SELECT  `id_user_dest` FROM `message` WHERE `id_user_exp`= '".$id."'  GROUP BY `id_user_dest` ";
            	$resultat=mysqli_query($link,$sql);
            	while($data=mysqli_fetch_assoc($resultat)){
                    $id_user_dest=$data['id_user_dest'];
                    $sql2="SELECT `user_name` FROM `profile_information` WHERE `user_id`='".$id_user_dest."'";
                    $resultat2=mysqli_query($link,$sql2);
                    $data2=mysqli_fetch_assoc($resultat2);
                    $user_name=$data2['user_name'];
                    $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$id_user_dest."'";
                    $resultat14=mysqli_query($link,$sql14);
                    $data14=mysqli_fetch_assoc($resultat14);
                    $photo_profil=$data14['profile_choisi'];
                      if($id_user_dest!=$id){
                       $user_name=$data2['user_name']; 
                       $photo_profil=$data14['profile_choisi'];
                  } 
                  else{ $user_name='Vous';$photo_profil=$_SESSION['photo_profil'];}   
                     echo "<hr><div class=\"contactmsg \"> <img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/> <a href=\"message.php?id_user=$id_user_dest\">$user_name</a></div> ";
                }
            }
        ?>
        </div>
</div>

<?php
}
else{
  header("location:connexion.php");
}
?>
</body>
</html>
