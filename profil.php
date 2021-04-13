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
      if (isset($_POST['tweet'])) {
        $text_tweet=$_POST['newTweet'];
        $sql6="INSERT INTO `tweet`(`id_tweet`, `user_id`, `text_tweet`, `date_tweet`, `nbr_likes`, `nbr_dislikes`, `nbr_retweet`) VALUES (0,'$id','$text_tweet',date('d-m-Y  H:i:s'),0,0,0)";
        $resultat6=mysqli_query($link,$sql6);
      }
      if (isset($_GET['notification'])) {
        if($_GET['notification']=='false'){
                    header("location:profil.php?user_name=$user_name&choix=tweets");
        }
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
    </form> <br><br>
              <?php if (isset($_GET['user_name'])) {
                $user_recherche=$_GET['user_name'];
                $sql8="SELECT * FROM `profile_information` WHERE `user_name`= '".$user_recherche."' ";
                  $resultat8 = mysqli_query($link,$sql8);
                $data8= mysqli_fetch_array($resultat8);
                $id_user_recherche=$data8['user_id'];
                $language_user_recherche=$data8['language'];
                $description_user_recherche=$data8['description'];
                $sql9="SELECT * FROM `user_formation` WHERE `user_id`= '".$id_user_recherche."'  ";
                  $resultat9 = mysqli_query($link,$sql9);
                $data9= mysqli_fetch_array($resultat9);
                $nom_etablissement=$data9['nom_etablissment'];
                $type_etablissement=$data9['type_etablissment'];
                $niveau=$data9['niveau'];
                $sql10="SELECT * FROM `profile_image` WHERE `user_id`= '".$id_user_recherche."' ";
                $resultat10 = mysqli_query($link,$sql10);
                $data10= mysqli_fetch_array($resultat10);
                $photo_profil_recherche=$data10['profile_choisi'];
                ?>
                <div style="background-color: #dddddd;width:100%;padding: 2px;border-radius: 25px;">
                <div style="width: 100%;">
                           <img src="photo/<?php echo $photo_profil_recherche;
                        ?> " alt="photo de profil"  style="width: 100px;height: 100px; border:10px solid  #72d0ca;border-radius: 25px;"/>
                </div>
                <div  style="font-weight: bold;font-size: 15px;width: 100%;"> 
                      <h2>@<?php echo $user_recherche; ?></h2>
                      <ul>
                        <li>Language:<?php echo $language_user_recherche; ?></li>
                        <li>Description : <?php echo $description_user_recherche ?></li>
                        <li>Nom d'établissement : <?php echo $nom_etablissement ?></li>
                        <li>Type d'établissement : <?php echo $type_etablissement ?></li>
                        <li>Niveau : <?php echo $niveau ?></li>


                      </ul>
               </div>
             </div>
                <?php 
                $sql14="SELECT * FROM `following` WHERE `follower_id`='".$id."' AND  `following_id`='".$id_user_recherche."'";
                $resultat14= mysqli_query($link,$sql14);
                 $data14= mysqli_fetch_array($resultat14);
                if(isset($data14)){
                  ?>
                  <a id="hrefFollow" href="profil.php?user_name=<?php  echo $user_recherche; ?>&follow=false&choix=tweets "><input type="submit" value="se désabonner" class="boutton" name="follow" id="follow" style="background-color: red;color: white;width: auto;"></a> 
                  <?php
                  }
                  else{
                 ?>
                <a id="hrefFollow" href="profil.php?user_name=<?php  echo $user_recherche; ?>&follow=true&choix=tweets "><input type="submit" value="S'abonner" class="boutton" name="follow" id="follow" style="width: auto;"></a> 
              <?php } ?>
                <a id="hrefMsg" href='message.php?message=newmessage&id_user_dest=<?php  echo $id_user_recherche; ?>&id_user_exp=<?php echo $_SESSION['id_user']; ?>'><button class="boutton" name="message" style="width: auto;">Message</button></a><br><br>
                <div class="navBarProfil">
                  <ul>
                  <li id="tweetactive" ><a href="profil.php?user_name=<?php echo $user_recherche ?>&choix=tweets"> Posts </a></li>
                  <li  id="retweetactive"><a  href="profil.php?user_name=<?php echo $user_recherche ?>&choix=retweets"> Partages</a></li>
                  <li id="followingactive"><a  href="profil.php?user_name=<?php echo $user_recherche ?>&choix=following"> Abonnements </a></li>
                  <li  id="followeractive"><a href="profil.php?user_name=<?php echo $user_recherche ?>&choix=follower"> Abonnées </a></li>
                  </ul>
                </div >
                <div id="liste_tweet">
                <?php    
                 $sql10="SELECT * FROM `tweet` WHERE `user_id`='".$id_user_recherche."'  ORDER BY `date_tweet` DESC ";
                  $resultat10= mysqli_query($link,$sql10);
                while($data10= mysqli_fetch_array($resultat10)){
                  $text_tweet=$data10['text_tweet'];
                  $date_tweet=$data10['date_tweet'];
                  $id_tweet=$data10['id_tweet'];
                  $sql17="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$id_user_recherche."'";
                  $resultat17=mysqli_query($link,$sql17);
                  $data17=mysqli_fetch_assoc($resultat17);
                   $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$id_user_recherche."'";
                                $resultat14=mysqli_query($link,$sql14);
                                $data14=mysqli_fetch_assoc($resultat14);
                                   $user_name=$data17['user_name']; 
                                     $photo_profil=$data14['profile_choisi'];
                                if($id_user_recherche!=$id){
                                     $name=$data17['user_name']; 
                                } 
                                else{ $name='Vous';}                  
                 
                        $sql14="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' AND `reacteur_id`='".$_SESSION['id_user']."' ";
                   $resultat14= mysqli_query($link,$sql14);
                   $data14= mysqli_fetch_array($resultat14);
                   $sql="SELECT * FROM `reaction` WHERE `tweet_id`='".$id_tweet."' ";
                   $result= mysqli_query($link,$sql);
                    $nb_aime = mysqli_num_rows($result);
                  if(isset($data14)){
                     echo "<div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"0> $name : </a> $text_tweet <span class=\"date_tweet\" >$date_tweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$id_user_recherche\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime)</div><br>";

                  }
                  else{
                   echo "<div class=\"text_tweet\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"0> $name : </a> $text_tweet <span class=\"date_tweet\" >$date_tweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user_recherche\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime)</div><br>";
                  }

                }
                echo "</div>";
                ?>
                <div id="liste_retweet">
                  <?php 
                            $sql15 ="SELECT * FROM `retweet` WHERE `retweeter_id`='".$id_user_recherche."'  ORDER BY `date_retweet` DESC ";
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
                                $sql17="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$tweet_user_id."'";
                                $resultat17=mysqli_query($link,$sql17);
                                $data17=mysqli_fetch_assoc($resultat17);
                                $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$id_user_recherche."'";
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

                            echo "<div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de : </p><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a><br> $text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span> <span class=\"date_tweet\" >Partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=false&id_tweet=$id_tweet&tweet_user_id=$id_user_recherche\"> <img id=\"aime$id_tweet\" src=\"jaime.png\" width=\"30\"/></a> ($nb_aime)</div><br><hr >";

                  }
                  else{
                     echo "<div class=\"text_tweet\"><p style=\"color:gray;\">Vous avez partager la publication de : </p><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px;border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $user_name : </a><br> $text_tweet  <span class=\"date_tweet\" >Publié le : $date_tweet</span> <span class=\"date_tweet\" >Partager le : $date_retweet</span><br><a href=\"Acceuil.php?retwett=$id_tweet\"><br><button type=\"submit\" class=\"boutton_reaction\" ><img src=\"retwetter.png\" width=\"50\"/></button></a> <a id=\"hrefaime$id_tweet\" href=\"Acceuil.php?aime=true&id_tweet=$id_tweet&tweet_user_id=$id_user_recherche\"> <img id=\"aime$id_tweet\" src=\"jaimepas.png\" width=\"30\"/></a> ($nb_aime)</div><br><hr >";
                  }

                          }
                   ?>
                </div>
                <div id="liste_following">
                  <?php 
                      $sql18 =" SELECT * FROM `following` WHERE `follower_id`='".$id_user_recherche."' ORDER BY `follow_up` DESC  ";
                       $resultat18= mysqli_query($link,$sql18);
                        while($data18= mysqli_fetch_array($resultat18)){
                            $following_id=$data18['following_id'];
                            $date_follow=$data18['date_follow'];
                            $sql19="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$following_id."'";
                            $resultat19=mysqli_query($link,$sql19);
                            $data19=mysqli_fetch_assoc($resultat19);
                              $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$following_id."'";
                                $resultat14=mysqli_query($link,$sql14);
                                $data14=mysqli_fetch_assoc($resultat14);
                                      $user_name=$data19['user_name']; 
                                     $photo_profil=$data14['profile_choisi'];
                                if($following_id!=$id){
                                     $name=$user_name; 
                                } 
                                else{ $name='Vous';}   
                              echo "<div class=\"text_tweet\" style=\"border-radius: 0px;background-color:white;\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $name  </a>  <span class=\"date_tweet\" >Date d'abonnement : $date_follow</span><br></div>";

                        }
                   ?>
                </div>
                <div id="liste_follower">
                  <?php 
                      $sql18 =" SELECT * FROM `following` WHERE `following_id`='".$id_user_recherche."' ORDER BY `follow_up` DESC  ";
                       $resultat18= mysqli_query($link,$sql18);
                        while($data18= mysqli_fetch_array($resultat18)){
                            $follower_id=$data18['follower_id'];
                            $date_follow=$data18['date_follow'];
                            $sql19="SELECT  `user_name` FROM `profile_information` WHERE `user_id`='".$follower_id."'";
                            $resultat19=mysqli_query($link,$sql19);
                            $data19=mysqli_fetch_assoc($resultat19);
                            $sql14="SELECT `profile_choisi` FROM `profile_image` WHERE `user_id`='".$follower_id."'";
                                $resultat14=mysqli_query($link,$sql14);
                                $data14=mysqli_fetch_assoc($resultat14);
                                       $user_name=$data19['user_name']; 
                                     $photo_profil=$data14['profile_choisi'];
                                if($follower_id!=$id){
                                     $name=$user_name; 
                                } 
                                else{ $name='Vous';}   
                              echo "<div class=\"text_tweet\" style=\"border-radius: 0px;background-color:white;\"><img src=\"photo/$photo_profil\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border-radius: 50%;\"/> <a href=\"profil.php?user_name=$user_name&choix=tweets\"> $name  </a>  <span class=\"date_tweet\" >Date d'Abonnement : $date_follow</span><br></div>";

                        }
                   ?>
                </div><br><br>

                <?php
                if (isset($_GET['choix'])) {
                  if($_GET['choix']=='tweets'){
                    ?>
                      <script type="text/javascript">
                      document.getElementById("liste_tweet").style.display = "block";
                      document.getElementById("liste_retweet").style.display = "none";
                       document.getElementById("liste_follower").style.display = "none";
                        document.getElementById("liste_following").style.display = "none";
                          document.getElementById("tweetactive").className= "activeLi";
                       </script>
                    <?php
                  }
                  else if ($_GET['choix']=='retweets') {
                      ?>
                      <script type="text/javascript">
                      document.getElementById("liste_tweet").style.display = "none";
                      document.getElementById("liste_retweet").style.display = "block";
                       document.getElementById("liste_follower").style.display = "none";
                        document.getElementById("liste_following").style.display = "none";
                         document.getElementById("retweetactive").className= "activeLi";
                       </script>
                    <?php
                  }
                  else if ($_GET['choix']=='following') {
                      ?>
                      <script type="text/javascript">
                      document.getElementById("liste_tweet").style.display = "none";
                      document.getElementById("liste_retweet").style.display = "none";
                       document.getElementById("liste_follower").style.display = "none";
                        document.getElementById("liste_following").style.display = "block";
                         document.getElementById("followingactive").className= "activeLi";
                       </script>
                    <?php
                  }
                        else if ($_GET['choix']=='follower') {
                      ?>
                      <script type="text/javascript">
                      document.getElementById("liste_tweet").style.display = "none";
                      document.getElementById("liste_retweet").style.display = "none";
                       document.getElementById("liste_follower").style.display = "block";
                        document.getElementById("liste_following").style.display = "none";
                         document.getElementById("followeractive").className= "activeLi";
                       </script>
                    <?php
                  }
                }
                if(isset($_GET['follow'])) {
                  if($_GET['follow']=='true'){
                    $follower_id=$id;
                    $following_id=$id_user_recherche;
                    $sql12="INSERT INTO `following`(`follower_id`, `following_id`, `follow_up`, `date_follow`) VALUES ('$follower_id','$following_id',0,date('d-m-Y  H:i:s'))";
                    $resultat12= mysqli_query($link,$sql12);

                    ?>
                  <script type="text/javascript">
                              document.getElementById("hrefFollow").href="profil.php?user_name=<?php  echo $user_recherche; ?>&follow=false&choix=tweets ";
                              document.getElementById("follow").value="Se désabonner";
                              document.getElementById("follow").style.backgroundColor='red';
                    </script>
                    <?php
                  }
                    else if($_GET['follow']=='false'){
                    $follower_id=$id;
                    $following_id=$id_user_recherche;
                    $sql13="DELETE FROM `following` WHERE `follower_id`='".$follower_id."' AND  `following_id`='".$following_id."'";
                    $resultat13= mysqli_query($link,$sql13);

                    ?>
                  <script type="text/javascript">
                              document.getElementById("hrefFollow").href="profil.php?user_name=<?php  echo $user_recherche; ?>&follow=true&choix=tweets ";
                              document.getElementById("follow").value="s'abonner";
                              document.getElementById("follow").style.backgroundColor='#015651';
                    </script>
                    <?php
                }
                 ?>
           
              <?php
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
