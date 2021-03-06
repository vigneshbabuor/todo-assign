<?php
require('api/db.php');
$_SESSION['username']='vignesh';
$_SESSION['id']='1';
$_SESSION['email']='vigneshbabuor@gmail.com';
if (!isset($_SESSION['id'])) {
    // Redirection to login page twitter or facebook
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Task list</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href='css/style.css' rel='stylesheet' type='text/css'/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/ajaxGetPost.js"></script>
</head>
<body>
  <nav class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">To-do-list</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active">Welcome <?php echo $_SESSION['username']; ?><li><li> <a href="logout.php?logout">Logout</a></li>
            </ul>
          </div></div>
      </nav>
<div class="wrap">
  <div class="task-list container"><section class="todo">

<form class="add-new-task" autocomplete="off">
<input type="text" name="new-task" pattern="[a-zA-Z0-9-_ |]{0,100}" placeholder="Add a new item..." />
</form>


<ul class="todo-list" id="todo-list">
</ul>
<span class="pending-count"></span>
</section>
</div>
<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>">
<input type="hidden" value="<?php echo $apiKey; ?>" id="apiKey"/>
</div>
<script>
$(document).ready(function()
{
var base_url="http://139.59.18.38/todo-assign/";
var url,encodedata,apiKey,user_id;
apiKey=$('#apiKey').val();
user_id=$('#user_id').val();


/* Load Updates */
function getupdates(){
url=base_url+'api/updates';
var html='';
encode=JSON.stringify({
        "user_id": user_id,
        "apiKey": apiKey
        });
post_ajax_data(url,encode, function(data)
{
$.each(data.updates, function(i,data)
{
var statuscheck=(data.status=='1')? "checked":"";
html+='<li class="list-group-item '+statuscheck+'" id="'+data.update_id+'"><input type="checkbox" id="'+data.update_id+'" '+statuscheck+'/><label  id="'+data.update_id+'" class="toggle" for="'+data.update_id+'"></label>'+data.user_update+'<span id="'+data.update_id+'" class="stdelete">X</span></li>';
});
$("#todo-list").html(html);
getcount(user_id);
});
}
getupdates();
function getcount(user_id){
url=base_url+'api/getcount/'+user_id;
ajax_data('get',url, function(data)
{
$.each(data.updates, function(i,data)
{
  $('.pending-count').html(data.count+' items left');
});
});

}
/* Insert Update */
$('.add-new-task').submit(function(){

  var update = $('.add-new-task input[name=new-task]').val();
  encode=JSON.stringify({
          "user_update": update,
          "user_id": user_id,
          "apiKey": apiKey
          });
  url=base_url+'api/insertUpdate';
  if(update.length>0)
  {
  post_ajax_data(url,encode, function(data)
  {
  $.each(data.updates, function(i,data)
  {
  var html='<li class="list-group-item" id="'+data.update_id+'"><input type="checkbox" id="'+data.update_id+'"/><label id="'+data.update_id+'" class="toggle" for="'+data.update_id+'"></label>'+data.user_update+'<span id="'+data.update_id+'" class="stdelete">X</span></li>';
  $("#todo-list").prepend(html);

  $('.add-new-task input[name=new-task]').val('');

  });
  });
  }
getcount(user_id);
  return false; // Ensure that the form does not submit twice
});

/* task Updates */
$('body').on("click",'.toggle',function()
{
  var current_element = $(this);
var ID=current_element.attr("id");
url=base_url+'api/updates/checked/'+ID+'/'+user_id+'/'+apiKey;
/*ajax_data('DELETE',url, function(data)
{
//$("#"+ID).fadeOut("slow");
current_element.parent().fadeOut("fast", function() { $(this).remove(); });
});*/
encode=JSON.stringify({
        "user_id": user_id,
        "apiKey": apiKey
        });
post_ajax_data(url,encode, function(data)
{
$.each(data.updates, function(i,data)
{
/*
var html='<li class="list-group-item" id="'+data.update_id+'"><input type="checkbox" id="'+data.update_id+'"/><label  id="'+data.update_id+'" class="toggle" for="'+data.update_id+'"></label>'+data.user_update+'<span id="'+data.update_id+'" class="stdelete">X</span></li>';
$(html).appendTo("#todo-list");
*/
getupdates();
});

});
});

/* Delete Updates */
$('body').on("click",'.stdelete',function()
{
  var current_element = $(this);
var ID=$(this).attr("id");
url=base_url+'api/updates/delete/'+ID+'/'+user_id+'/'+apiKey;
ajax_data('DELETE',url, function(data)
{
//$("#"+ID).fadeOut("slow");
current_element.parent().fadeOut("fast", function() { $(this).remove(); });
});
getcount(user_id);
});

});
</script>

</body></html>
