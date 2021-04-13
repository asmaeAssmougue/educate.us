$(document).ready(function () {

  setInterval(() => {
    axios.get("mainAjax.php?action=notification").then(res => {
      if(res.data.length > 0){
          var noti = "";
          res.data.forEach(element => {
            noti += element["content_notification"] + "<br/>";
          });
        $("#alert_success").html(noti);
        $("#alert_success").addClass("show");
        $(".notificaiton .noti").addClass("show");
      }
    })

  }, 5000);

  $("#notification").click(function(e){
    e.preventDefault();
     axios.get("mainAjax.php?action=getNotification")
    .then(res => {
      array = res.data;
      console.log(array)
      var output = "";
       array.forEach(element => {
        output  = output + '<div class="notifi">' + element["content_notification"] +'</div>'
      });
      console.log(output);
      $(".barNotification .ulNotification").html(output);
      $(".barNotification").addClass("show");
    })
  })

  $('#closeNotificaion').click(function(){
    $(".barNotification").removeClass("show");
  })

  $("#hideAlert").click(function(){
    $("#alert_success").removeClass("show");
  })

  $("#searchBar").submit(function (e) { 
    e.preventDefault();
    if($("#rechercher").val() != ""){
      axios.post("mainAjax.php?action=search&&searchlibel=" + $("#rechercher").val())
      .then(res =>{
       if(res.data.length > 0){
         console.log(res.data);
         var  array = res.data;
         var resu = "";
         array.forEach(element => {
          resu += '<li class="item"><a href="profil.php?user_id=' + element["user_id"] +'">' + element["user_name"] + '</li>'
         });
         $("#result_recherche").html(resu)
         $("#result_recherche").addClass("show");

        }else{
         $("#result_recherche").html('<li class="item"> no results </li>')
        }
      })
      
    }else{
      $("#result_recherche").removeClass("show");
    }
  });


});


const searchChange = function(){
  console.log("test")
  if($("#rechercher").val() != ""){
    axios.post("mainAjax.php?action=search&&searchlibel=" + $("#rechercher").val())
    .then(res =>{
     if(res.data.length > 0){
       console.log(res.data);
       var  array = res.data;
       var resu = "";
       array.forEach(element => {
        resu += '<li class="item"><a href="profile.php?user_id=' + element["user_id"] +'">' + element["user_name"] + '</li>'
       });
       $("#result_recherche").html(resu)
       $("#result_recherche").addClass("show");

      }else{
       $("#result_recherche").html('<li class="item"> no results </li>')
      }
    })
    
  }else{
    $("#result_recherche").removeClass("show");
    
  }
}