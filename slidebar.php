<div class="aside position-relative">
<div id="barNotification">
    <span class="btn-close"> <i class="fa fa-times" id="closeNotificaion" aria-hidden="true"></i> </span>
    <h4><u>Notifications</u></h4>
    <div class="ulNotification">
      <?php 
      $sql="SELECT * FROM `notification` WHERE `user_id` = '".$_SESSION['id_user']."' ORDER BY notification_id  DESC LIMIT 5";
      $rst=mysqli_query($link,$sql);
      while($data=mysqli_fetch_assoc($rst)){
           $noti= $data['type_activitie'];
             echo "<div><img src=\"noti.png\" style=\"width:20px;\">$noti</div><br>";
      }
     ?>
    </div>
</div>
  <nav>
  <div class="navBar">
    <ul>
      <li><img src="logo3.png" width="100"></li>
       <li><a href="Acceuil.php" style="color:#000;font-size:1.3em;">Acceuil</a></li>
      <li><a href="message.php" style="color:#000;font-size:1.3em;">Messages</a></li>
       <li><a href="?notification=true" id="notification"  class="notificaiton" style="color:#000;font-size:1.3em;"> Notification <span class="noti"> </span></a></li>
      <li><a href="profil.php?user_name=<?php echo $user_name ?>&choix=tweets" style="color:#000;font-size:1.3em;">Profil</a></li>
       <li><a href="parametres.php" style="color:#000;font-size:1.3em;">Paramètres</a></li><br><br>
       <li><link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet">
          
          <link rel="stylesheet" href="font/fontawesome-free-5.15.2-web/css/all.css">
  <style type="text/css">
    *{
      box-sizing:border-box;
    }
    body{
      display:flex;
      justify-content:center;
      align-items:center;
      margin:0;
      transition:background 0.2s linear;
    }
    body.dark{
      background-color:#292C35; 
    }
    .checkbox{
                  opacity:0;
                  position:absolute;
    }
    
    .label{
      background-color:#111;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:5px;
      position:relative;
      border-radius:50px;
      height:26px;
      width:50px;
      
    }
    .fa-moon{
      color:#f1c40f;
      width:15px;

    }
    .fa-sun{
      color:#f39c12;
      width:15px;
      

    }
    .ball{
      background-color:#fff;
      border-radius:50%;
      position:absolute;
      top:2px;
      left:2px;
      width:23px;
      height:23px;
      transition:transform 0.2s linear;

    }
    .checkbox:checked + .label .ball{
      transform:translateX(24px); 
    }
  </style>
</head>
<body>
  <div>
      <input type="checkbox" class="checkbox" id="checkbox">
      <label for="checkbox" class="label"><i class="fas fa-moon"></i>
        <i class="fas fa-sun"></i>
        <div class="ball"></div>
      </label>
  </div>
         <script type="text/javascript">
          const checkbox = document.getElementById('checkbox');
          checkbox.addEventListener('change',()=>{
            //change the theme of the website
            document.body.classList.toggle('dark');
          })

         </script></li>
  </ul>
  </div>
  <div class="navbarForter">
    <h4 class="user_name">@<?php if(isset($user_name)){ echo $user_name;}?> </h4>
      <img src="photo/<?php 
      if(isset($_SESSION['photo_profil'])){
        echo $_SESSION['photo_profil'];
      }
    ?> " alt="photo de profil" class="photo_de_profil"/><br><br>
      <a href='Acceuil.php?deconnexion=true'><button class="boutton" style="width: auto;">Déconnexion</button></a> 
  </div>
  </nav>
</div>
<?php 
if (isset($_GET['notification'])) {
  if ($_GET['notification']=='true') {
    ?>
    <script type="text/javascript">
        document.getElementById("barNotification").style.display="block";
        document.getElementById("notification").href="?notification=false";
    </script>
    <?php
  }
    elseif($_GET['notification']=='false') {
    ?>
    <script type="text/javascript">
        document.getElementById("barNotification").style.display="none";
        document.getElementById("notification").href="?notification=true";
    </script>
    <?php
  }
}
 ?>

<style>
.notificaiton{
  position: relative;
}
.notificaiton .noti{
  position: absolute;
    top: 0%;
    transform: translateY(-50%);
    margin: 5px;
    color: white;
    background-color: red;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    display: none;
    right: -20px;
}
</style>