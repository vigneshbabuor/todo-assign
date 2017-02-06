<?php
//Always place this code at the top of the Page
session_start();
if (isset($_SESSION['id'])) {
    // Redirection to login page twitter or facebook
    header("location: home.php");
}

if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'twitter') {
        header("Location: login-twitter.php");
    } else if ($oauth_provider == 'facebook') {
        header("Location: login-facebook.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Task list social login</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href='css/bootstrap-social.css' rel='stylesheet' type='text/css'/>
<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style type="text/css">
    #buttons
	{
	text-align:center
	}
    #buttons img,
    #buttons a img
    { border: none;}
	h1
	{
	font-family:Arial, Helvetica, sans-serif;
	color:#999999;
	}
  .maincontainer {
      position : absolute;
      display: table;
      width: 100%; /* This could be ANY width */
      height: 100%; /* This could be ANY height */
      background: #ccc;
  }

  #container {
      display: table-cell;
      vertical-align: middle;
      text-align: center;
  }

  .centercontent {
      display: inline-block;
      text-align: left;
      background: #fff;
      padding : 20px;
      height:300px;
  }
</style>

</head><body>

<div class="maincontainer">
<div id="container">
<div class="centercontent">
<a class="btn btn-block btn-social btn-twitter" href="login-twitter.php">
<span class="fa fa-twitter"></span> Sign in with Twitter
</a></div>
</div>
</div>
</body></html>
