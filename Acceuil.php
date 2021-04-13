<?php 
session_start(); 
include('connexion_base.php');
$id=$_SESSION['id_user'];
$user_name= $_SESSION['user_name'];
$photo_profil=$_SESSION['photo_profil'];
if(!empty($id) ){
        if(isset($_GET['deconnexion']))
                { 
                   if($_GET['deconnexion']==true)
                   {  
                      session_destroy();
                      header("location:connexion.php");
                   }
        }
      if (isset($_POST['tweet']) ) {
      if(isset($_POST['newTweet'])){
        $text_tweet=$_POST['newTweet'];
        $sql6="INSERT INTO `tweet`(`id_tweet`, `user_id`, `text_tweet`, `date_tweet`) VALUES (0,'$id','$text_tweet',date('d-m-Y  H:i:s'))";
        $resultat6=mysqli_query($link,$sql6);
         header("location:Acceuil.php");
      }
    }
      else if(isset($_POST['retweet'])){
        $sql8="SELECT  `user_id`, `text_tweet`, `date_tweet` FROM `tweet` WHERE `id_tweet`='".$_GET['retwett']."'";
        $resultat8=mysqli_query($link,$sql8);
        $data8=mysqli_fetch_assoc($resultat8);
        $user_id=$data8['user_id'];        
        $tweet_id=$_GET['retwett'];
        $sql10="INSERT INTO `retweet`(`tweet_id`, `retweeter_id`, `tweet_user_id`, `date_retweet`) VALUES ('$tweet_id','$id','$user_id',date('d-m-Y  H:i:s'))";
        $resultat10=mysqli_query($link,$sql10);
        header("location:Acceuil.php");
      }




?>
<!DOCTYPE  html>
<html>
    <head>
        <title>Profil</title>
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
    <br><br>
    <h2 class="titre">Acceuil</h2>
    <form action="" method="post" style="width: 100%;">
  <hr>
      <div id="photoProfil"><img src="photo/<?php 
          if(isset($_SESSION['photo_profil'])){
            echo $_SESSION['photo_profil'];
          }
        ?> " alt="photo de profil"  style="width: 50px;height: 50px; border:4px solid  white;border-radius: 50%;"/>
      </div>

  <?php if (isset($_GET['retwett'])) {
    $sql8="SELECT  `user_id`, `text_tweet`, `date_tweet` FROM `tweet` WHERE `id_tweet`='".$_GET['retwett']."'";
    $resultat8=mysqli_query($link,$sql8);
    $data8=mysqli_fetch_assoc($resultat8);
    $text_tweet=$data8['text_tweet'];
    $date_tweet=$data8['date_tweet'];
    $user_id=$data8['user_id'];
    $sql9="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$user_id."'";
    $resultat9=mysqli_query($link,$sql9);
    $data9=mysqli_fetch_assoc($resultat9);
    $user_name=$data9['user_name'];
  $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$user_id."'";
  $resultat14=mysqli_query($link,$sql14);
    $data14=mysqli_fetch_assoc($resultat14);
    $photo_profil=$data14['profile_choisi'];    
    ?> 
<br>
  
    <?php   echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 25px;height: 25px; border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name\"> $user_name : </a> $text_tweet <br><br><button class=\"boutton\" name=\"retweet\" style=\"width: auto;float: right;\" >Partager</button>  <span class=\"date_tweet\" >Publié le : $date_tweet</span></div><br>"; ?>
    <?php 
  }
  else{ ?>
         <textarea name="newTweet" class="tweet" placeholder="Postez quelque chose........ " rows="5" cols="100"></textarea><br>
      
         <button class="boutton" name="tweet" style="width: auto;clear:both;float: right;" >Poster</button>  <?php } ?>
   <br><br> </form>
      <?php 
        $sql11="SELECT * FROM `following` WHERE `follower_id`='".$id."' OR `following_id` = '".$id."' ";
        $resultat11=mysqli_query($link,$sql11);
        if(mysqli_num_rows($resultat11)!==0){
        while(($data11=mysqli_fetch_assoc($resultat11))){
        $follower_id=$data11['follower_id'];
        $following_id=$data11['following_id'];
        $sql12="SELECT  `id_tweet`,`user_id`, `text_tweet`, `date_tweet` FROM `tweet` WHERE `user_id` ='".$follower_id."' OR `user_id` = '".$following_id."'  ORDER BY date_tweet DESC LIMIT 20";
        $resultat12=mysqli_query($link,$sql12);
        while($data12=mysqli_fetch_assoc($resultat12)){
              $text_tweet=$data12['text_tweet'];
              $date_tweet=$data12['date_tweet'];
              $id_tweet=$data12['id_tweet'];
              $id_user=$data12['user_id'];
              $sql13="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$id_user."'";
              $resultat13=mysqli_query($link,$sql13);
              $data13=mysqli_fetch_assoc($resultat13);
              $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$id_user."'";
              $resultat14=mysqli_query($link,$sql14);
              $data14=mysqli_fetch_assoc($resultat14);
              if($id_user!=$id){
                   $user_name=$data13['user_name']; 
                   $photo_profil=$data14['profile_choisi'];
                   $sql14="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id`='".$_SESSION['id_user']."' ";
                   $resultat14= mysqli_query($link,$sql14);
                   $data14= mysqli_fetch_array($resultat14);
                   $sql="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' ";
                   $result= mysqli_query($link,$sql);
                    $nb_aime = mysqli_num_rows($result);
                  if(isset($data14)){
                    echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/><a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> $text_tweet <br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime)<span class=\"date_tweet\" >Publié le : $date_tweet</span></div><br>";

                  }
                  else{
                     echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/><a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> $text_tweet <br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime)<span class=\"date_tweet\" >Publié le : $date_tweet</span></div><br>";
                  }


              } 
              else{ $user_name=$_SESSION['user_name'] ;$photo_profil=$_SESSION['photo_profil'];

                 $sql14="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id`='".$_SESSION['id_user']."' ";
                   $resultat14= mysqli_query($link,$sql14);
                   $data14= mysqli_fetch_array($resultat14);
                   $sql="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' ";
                   $result= mysqli_query($link,$sql);
                    $nb_aime = mysqli_num_rows($result);
                  if(isset($data14)){
                    echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/><a href=\"profil.php?user_name=$user_name&choix=tweets\"> Vous : </a> $text_tweet <br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime)<span class=\"date_tweet\" >Publié le : $date_tweet</span></div><br>";

                  }
                  else{
                     echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/><a href=\"profil.php?user_name=$user_name&choix=tweets\"> Vous : </a> $text_tweet <br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime)<span class=\"date_tweet\" >Publié le : $date_tweet</span></div><br>";
                  }

            }             

        }
         $sql15 ="SELECT * FROM `retweet` WHERE `retweeter_id`='".$id."'  ORDER BY `date_retweet` DESC ";
                            $resultat15= mysqli_query($link,$sql15);
                          while($data15= mysqli_fetch_array($resultat15)){
                            $date_retweet=$data15['date_retweet'];
                            $id_tweet=$data15['tweet_id'];
                            $tweet_user_id=$data15['tweet_user_id'];
                                $sql16="SELECT  `user_id`, `text_tweet`, `date_tweet` FROM `tweet` WHERE `id_tweet`='".$id_tweet."'";
                                $resultat16=mysqli_query($link,$sql16);
                                $data16=mysqli_fetch_assoc($resultat16);
                                $text_tweet=$data16['text_tweet'];
                                $date_tweet=$data16['date_tweet'];
                                $tweet_user_id=$data16['user_id'];
                                $sql17="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$tweet_user_id."'";
                                $resultat17=mysqli_query($link,$sql17);
                                $data17=mysqli_fetch_assoc($resultat17);
                                $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$tweet_user_id."'";
                                $resultat14=mysqli_query($link,$sql14);
                                $data14=mysqli_fetch_assoc($resultat14);
                                     $user_name=$data17['user_name']; 
                                     $photo_profil=$data14['profile_choisi'];  
                                     $sql14="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id`='".$_SESSION['id_user']."' ";
                   $resultat14= mysqli_query($link,$sql14);
                   $data14= mysqli_fetch_array($resultat14);
                   $sql="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' ";
                   $result= mysqli_query($link,$sql);
                    $nb_aime = mysqli_num_rows($result);

                           
                     if(isset($data14)){
                      echo "<hr><div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de :</p><br><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> <br>$text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span><br><span class=\"date_tweet\" >Partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$tweet_user_id\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime) </div><br>";

                  }
                  else{
                   echo "<hr><div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de :</p><br><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> <br>$text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span><br><span class=\"date_tweet\" >Partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime) </div><br>";
                  }
                          }
      }
    }
      else{
        $sql10="SELECT * FROM `tweet` WHERE `user_id`='".$id."'  ORDER BY `date_tweet` DESC LIMIT 10 ";
        $resultat10= mysqli_query($link,$sql10);
        if(mysqli_num_rows($resultat10)!==0){
            while($data10= mysqli_fetch_array($resultat10)){
              $text_tweet=$data10['text_tweet'];
              $date_tweet=$data10['date_tweet'];
              $id_tweet=$data10['id_tweet'];
              $user_name=$_SESSION['user_name'];
              echo "<hr><div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 100px;height: 100px; ;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\">Vous : </a>  $text_tweet <span class=\"date_tweet\" >Publié le : $date_tweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a></div><br>";
            }
          }
              $sql15 ="SELECT * FROM `retweet` WHERE `retweeter_id`='".$id."'  ORDER BY `date_retweet` DESC ";
                            $resultat15= mysqli_query($link,$sql15);
                              if(mysqli_num_rows($resultat15)!==0){
                            while($data15= mysqli_fetch_array($resultat15)){
                            $date_retweet=$data15['date_retweet'];
                            $id_tweet=$data15['tweet_id'];
                            $tweet_user_id=$data15['tweet_user_id'];
                                $sql16="SELECT  `user_id`, `text_tweet`, `date_tweet` FROM `tweet` WHERE `id_tweet`='".$id_tweet."'";
                                $resultat16=mysqli_query($link,$sql16);
                                $data16=mysqli_fetch_assoc($resultat16);
                                $text_tweet=$data16['text_tweet'];
                                $date_tweet=$data16['date_tweet'];
                                $tweet_user_id=$data16['user_id'];
                                $sql17="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$tweet_user_id."'";
                                $resultat17=mysqli_query($link,$sql17);
                                $data17=mysqli_fetch_assoc($resultat17);
                                $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$tweet_user_id."'";
                                $resultat14=mysqli_query($link,$sql14);
                                $data14=mysqli_fetch_assoc($resultat14);
                                     $user_name=$data17['user_name']; 
                                     $photo_profil=$data14['profile_choisi'];          

                    $sql14="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id`='".$_SESSION['id_user']."' ";
                   $resultat14= mysqli_query($link,$sql14);
                   $data14= mysqli_fetch_array($resultat14);
                   $sql="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' ";
                   $result= mysqli_query($link,$sql);
                    $nb_aime = mysqli_num_rows($result);

                           
                               if(isset($data14)){
                         echo "<hr><div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de :</p><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> <br>$text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span><br><span class=\"date_tweet\" >partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime)</div><br>";

                  }
                  else{
                         echo "<hr><div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de :</p><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a> <br>$text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span><br><span class=\"date_tweet\" >partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime) </div><br>";
                  }
                          }
      }
      else{
        echo "<h3 style=\"text_align:center\"><b>Commencez par suivre une personne ou poster un tweet</b></h3>";
      }

    }
       ?>
    </div>
  </div>
<?php
             if(isset($_GET['aime']) && isset($_GET['id_tweet']) && isset($_GET['tweet_user_id'])) {
              $id_tweet=$_GET['id_tweet'];
              $reacteur_id=$_SESSION['id_user'];
              $tweet_user_id=$_GET['tweet_user_id'];
                  if($_GET['aime']=='true'){
                    $sql="INSERT INTO `reaction`(`tweet_user_id`, `tweet_id`, `reacteur_id`, `type_of_reaction`) VALUES ('$tweet_user_id','$id_tweet','$reacteur_id','aime')";
                    $rst=mysqli_query($link,$sql);
                    ?>
                  <script type="text/javascript">
                              document.getElementById("hrefaime<?php echo $id_tweet?>").href="Acceuil.php?aime=false&id_tweet=<?php echo $id_tweet;?>&tweet_user_id=<?php echo $tweet_user_id;?>";
                              document.getElementById("aime<?php echo $id_tweet?>").src="jaime.png";
                    </script>
                    <?php

                  }
                    else if($_GET['aime']=='false'){
                      $sql="DELETE FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id` = '".$reacteur_id."'";
                    $rst=mysqli_query($link,$sql);

                    ?>
                  <script type="text/javascript">
                              document.getElementById("hrefaime<?php echo $id_tweet?>").href="Acceuil.php?aime=true&id_tweet=<?php echo $id_tweet;?>&tweet_user_id=<?php echo $tweet_user_id;?>";
                              document.getElementById("aime<?php echo $id_tweet?>").src="jaimepas.png";
                    </script>
                    <?php
                }
                ?>
                <script type="text/javascript">
                 document.location.assign('Acceuil.php');
                </script>
                <?php
              }
}
else{
  header("location:connexion.php");
}
?>
</body>
</html>
